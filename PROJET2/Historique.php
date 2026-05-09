<?php
session_start();
include_once("section/Fonction/fonction.php");

if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== "client") {
    header("Location: Connexion.php");
    exit();
}

$user = $_SESSION["user"];
$commandes = lireJson("section/JSON/commandes.json");
$historique = [];

foreach ($commandes as $commande) {
    if (isset($commande["client_id"]) && $commande["client_id"] == $user["id"]) {
        $historique[] = $commande;
    }
}

$historique = array_reverse($historique);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Historique</title>
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
    <link rel="stylesheet" href="CSS/styleHistorique.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
    <script src="section/Javascript/theme.js" defer></script>
</head>
<script src="section/Javascript/check_bloque.js" defer></script>
<body>

<?php include 'section/Navigation.php'; ?>

<div class="effetNoir">
    <section class="historique-page">
        <div class="titre-page">
            <h1>Historique de mes commandes</h1>
        </div>

        <div class="tableau-conteneur">
            <?php if (empty($historique)): ?>
                <div class="aucune-commande">
                    <p>Vous n'avez encore passé aucune commande.</p>
                </div>
            <?php else: ?>
                <table class="tableau-historique">
                    <thead>
                        <tr>
                            <th>ID commande</th>
                            <th>Date</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th>Service</th>
                            <th>Statut</th>
                            <th>Paiement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historique as $commande): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($commande["id"] ?? ""); ?></td>
                                <td>
                                    <?php
                                    if (!empty($commande["date_creation"])) {
                                        echo htmlspecialchars(date("d/m/Y H:i", strtotime($commande["date_creation"])));
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($commande["articles"]) && is_array($commande["articles"])) {
                                        $listeArticles = [];
                                        foreach ($commande["articles"] as $article) {
                                            $nom = $article["nom"] ?? "Article";
                                            $quantite = $article["quantite"] ?? 1;
                                            $listeArticles[] = $nom . " x" . $quantite;
                                        }
                                        echo htmlspecialchars(implode(", ", $listeArticles));
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td><?php echo number_format((float)($commande["total"] ?? 0), 2, ",", " "); ?> €</td>
                                <td><?php echo htmlspecialchars($commande["type_service"] ?? "-"); ?></td>
                                <td><?php echo htmlspecialchars($commande["statut"] ?? "-"); ?></td>
                                <td><?php echo htmlspecialchars($commande["paiement_statut"] ?? "-"); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>
</div>

</body>
</html>