<?php
session_start();
include_once("section/Fonction/fonction.php");

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "client") {
    header("Location: Connexion.php");
    exit();
}

$commandeId = trim($_GET["commande_id"] ?? "");
if ($commandeId === "") {
    header("Location: Historique.php");
    exit();
}

$commandes = lireJson("section/JSON/commandes.json");
$commande = null;
foreach ($commandes as $c) {
    if (($c["id"] ?? "") === $commandeId && (string)($c["client_id"] ?? "") === (string)$_SESSION["user"]["id"]) {
        $commande = $c;
        break;
    }
}

if ($commande === null) {
    header("Location: Historique.php");
    exit();
}

$statutsModifiables = ["à préparer", "à attendre"];
if (!in_array($commande["statut"] ?? "", $statutsModifiables, true) || ($commande["paiement_statut"] ?? "") !== "complété") {
    header("Location: Historique.php");
    exit();
}

$plats = lireJson("section/JSON/plats.json");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Modifier la commande</title>
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" href="CSS/styleModifierCommande.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
</head>
<body>
<?php include 'section/Navigation.php'; ?>

<div class="effetNoir">
    <section class="modifier-page">

        <h1>Modifier la commande</h1>
        <p class="info-commande">
            Commande : <strong><?= htmlspecialchars($commandeId) ?></strong>
            &nbsp;|&nbsp; Statut : <strong><?= htmlspecialchars($commande["statut"]) ?></strong>
        </p>

        <!-- Articles actuels -->
        <h2>Articles dans la commande</h2>
        <div id="articlesList">
            <?php foreach ($commande["articles"] as $article): ?>
            <div class="article-ligne"
                 data-nom="<?= htmlspecialchars($article["nom"]) ?>"
                 data-prix="<?= $article["prix_unitaire"] ?>">
                <span class="article-nom"><?= htmlspecialchars($article["nom"]) ?></span>
                <span class="article-prix"><?= number_format($article["prix_unitaire"], 2, ',', '') ?> €</span>
                <button class="btn-qte" onclick="diminuerQte(this)">−</button>
                <span class="article-qte"><?= (int)$article["quantite"] ?></span>
                <button class="btn-qte" onclick="augmenterQte(this)">+</button>
                <button class="btn-suppr" onclick="supprimerArticle(this)">Supprimer</button>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Ajouter un plat -->
        <h2>Ajouter un plat</h2>
        <div class="grille-ajout">
            <?php foreach ($plats as $plat): ?>
            <div class="carte-ajout">
                <img src="<?= htmlspecialchars($plat["image"] ?? '') ?>" alt="<?= htmlspecialchars($plat["nom"] ?? '') ?>">
                <p><?= htmlspecialchars($plat["nom"]) ?></p>
                <p class="prix-plat"><?= number_format($plat["prix"], 2, ',', '') ?> €</p>
                <button class="btn-ajouter-plat"
                    onclick="ajouterPlat('<?= addslashes($plat["nom"]) ?>', <?= $plat["prix"] ?>)">
                    + Ajouter
                </button>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Totaux -->
        <div class="bloc-total">
            <p>Ancien total : <strong><?= number_format($commande["total"], 2, ',', '') ?> €</strong></p>
            <p>Nouveau total : <strong id="nouveauTotal"><?= number_format($commande["total"], 2, ',', '') ?> €</strong></p>
            <p id="messageDiff"></p>
        </div>

        <!-- Actions -->
        <div class="actions-bas">
            <button class="btn-valider" onclick="validerModification()">Valider les modifications</button>
            <a href="Historique.php" class="btn-annuler">Annuler</a>
        </div>

        <div id="messageRetour"></div>

    </section>
</div>

<script>
    const ancienTotal = <?= json_encode(round((float)$commande["total"], 2)) ?>;
    const commandeId  = <?= json_encode($commandeId) ?>;
</script>
<script src="section/Javascript/modifierCommande.js"></script>

</body>
</html>
