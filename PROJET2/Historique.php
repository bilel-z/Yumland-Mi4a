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

function formaterArticles($articles) {
    if (empty($articles) || !is_array($articles)) { return "-"; }
    $liste = [];
    foreach ($articles as $article) {
        $nom      = $article["nom"] ?? "Article";
        $quantite = $article["quantite"] ?? 1;
        $liste[]  = $nom . " x" . $quantite;
    }
    return htmlspecialchars(implode(", ", $liste));
}

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
    <script src="section/Javascript/theme.js" defer></script>
    <link rel="stylesheet" href="CSS/styleHistorique.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
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
                            <th>Action</th>
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
                                    <?php echo formaterArticles($commande["articles"] ?? []); ?>
                                </td>
                                <td><?php echo number_format((float)($commande["total"] ?? 0), 2, ",", " "); ?> €</td>
                                <td><?php echo htmlspecialchars($commande["type_service"] ?? "-"); ?></td>
                                <td><?php echo htmlspecialchars($commande["statut"] ?? "-"); ?></td>
                                <td><?php echo htmlspecialchars($commande["paiement_statut"] ?? "-"); ?></td>
                                <td>
                                    <?php
                                    $estModifiable =
                                        ($commande["paiement_statut"] ?? "") === "complété" &&
                                        in_array($commande["statut"] ?? "", ["à préparer", "à attendre"]);
                                    ?>
                                    <?php if ($estModifiable): ?>
                                        <a href="ModifierCommande.php?commande_id=<?= urlencode($commande["id"]) ?>" class="btn-modifier-commande">Modifier</a>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
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