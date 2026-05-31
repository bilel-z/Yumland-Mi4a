<?php
include_once("section/Fonction/fonction.php");
securiserCookieSession();
session_start();

//On vérifie si l'utilisateur connecté est un livreur
$estLivreur = isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'livreur';

if ($estLivreur && isset($_POST["Livraison"])) {
    //On vérifie que la requête vient bien du site
    if (!requeteInterne()) { http_response_code(403); exit("Requête refusée."); }
    $commande = lireJson("section/JSON/commandes.json");

    //On cherche la commande en cours de livraison assignée à ce livreur
    foreach ($commande as &$c) {
        if (
            isset($c["livreur_id"], $c["statut"]) &&
            $c["livreur_id"] == $_SESSION["user"]["id"] &&
            $c["statut"] == "en livraison"
        ) {
            //On met à jour le statut selon le choix du livreur
            if ($_POST["Livraison"] == "oui") {
                $c["statut"] = "livrée";
            } elseif ($_POST["Livraison"] == "non") {
                $c["statut"] = "abandonnée";
            }
            //On enregistre la date de la livraison
            $c["date_retrait_livraison"] = date("Y-m-d H:i:s");
            break;
        }
    }

    //On sauvegarde les modifications dans le JSON
    unset($c);
    ecrireJson("section/JSON/commandes.json", $commande);
}

//On cherche si le livreur a une commande en cours à afficher
$livraison = null;

if ($estLivreur) {
    $commandes = lireJson("section/JSON/commandes.json");
    //On parcourt les commandes pour trouver celle assignée à ce livreur avec le statut "en livraison"
    foreach ($commandes as $c) {
        if (
            isset($c["livreur_id"], $c["statut"]) &&
            $c["livreur_id"] == $_SESSION["user"]["id"] &&
            $c["statut"] == "en livraison"
        ) {
            $livraison = $c;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Livraison</title>
    <link rel="stylesheet" href="CSS/Livraison.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
    <script src="section/Javascript/theme.js" defer></script>
</head>
<script src="section/Javascript/check_bloque.js" defer></script>
<body>

<?php include 'section/Navigation.php'; ?>
<div class="Teinte"></div>

<div class="centrage">
    <div class="carte-blanche">

        <?php if ($estLivreur): ?>

            <h2>Livraison</h2>

            <?php if ($livraison !== null): ?>
                <h3>Commande <?php echo htmlspecialchars($livraison["id"] ?? ""); ?></h3>

                <div class="Livraison-contenu">
                    <div class="Livraison-info">
                        <p><strong>Adresse :</strong><br><?php echo htmlspecialchars($livraison["adresse_livraison"] ?? ""); ?></p>
                        <p><strong>Interphone :</strong> <?php echo htmlspecialchars($livraison["client_interphone"] ?? ""); ?></p>
                        <p><strong>Téléphone :</strong><br><?php echo htmlspecialchars($livraison["client_telephone"] ?? ""); ?></p>
                        <p><strong>Commentaires :</strong><br><?php echo htmlspecialchars($livraison["commentaire"] ?? ""); ?></p>
                    </div>

                    <div class="mapss">
                        <div class="image-maps"></div>
                        <a
                            href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($livraison['adresse_livraison'] ?? ''); ?>"
                            class="maps"
                            target="_blank">
                            Ouvrir dans Maps
                        </a>
                    </div>
                </div>

                <form method="post">
                    <input type="hidden" name="Livraison" value="oui">
                    <button type="submit" class="LivraisonTerminee">Livraison terminée</button>
                </form>

                <form method="post">
                    <input type="hidden" name="Livraison" value="non">
                    <button type="submit" class="LivraisonTerminee">Livraison abandonnée</button>
                </form>

            <?php else: ?>
                <h3>Aucune commande en livraison</h3>
                <p style="text-align:center; font-size:18px; margin-top:20px;">
                    Vous n'avez actuellement aucune commande à livrer.
                </p>
            <?php endif; ?>

        <?php else: ?>

            <h2>Livraison</h2>
            <p style="text-align:center; font-size:18px; margin-top:20px;">
                Cette page est réservée aux livreurs connectés.
            </p>
            <p style="text-align:center; margin-top:10px;">
                Connectez-vous avec un compte livreur pour accéder aux livraisons.
            </p>

        <?php endif; ?>

    </div>
</div>

</body>
</html>