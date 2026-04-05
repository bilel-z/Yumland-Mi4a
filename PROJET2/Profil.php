<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/profil.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
<body>
<?php
include_once("section/Fonction/fonction.php");

if (!isset($_SESSION["user"])) {
    header("Location: Connexion.php");
    exit();
}

if (isset($_GET["id"])) {
    $users = lireJson("section/JSON/utilisateurs.json");
    $user = null;
    foreach ($users as $u) {
        if ($u["id"] == $_GET["id"]) {
            $user = $u;
            break;
        }
    }

    if ($user === null) {
        header("Location: Admin.php");
        exit();
    }
} else {
    $user = $_SESSION["user"];
}

$commandesUtilisateur = [];
$commandes = lireJson("section/JSON/commandes.json");
foreach($commandes as $commande){
    if(isset($commande['client_id']) && $commande['client_id'] == $user['id']){
        $commandesUtilisateur[] = $commande;
    }
}
$commandesUtilisateur = array_reverse($commandesUtilisateur);
?>
<?php include 'section/Navigation.php'; ?>

<div class="Teinte"></div>

<div class="centrage">

    <div class="carte-blanche profil-global">

        <div class="profil-gauche">

            <div class="photo-profil">
                <img src="image/pdp.jpeg" alt="Photo de profil">
            </div>

            <h2><?php echo htmlspecialchars($user["Nom"] . ' ' . $user["Prenom"]); ?></h2>

            <div class="infos-profil">
                <p><strong>Nom :</strong> <?php echo $user["Nom"]?></p>
                <p><strong>Email :</strong> <?php echo $user["Mail"]?></p>
                <p><strong>Téléphone :</strong> <?php echo $user["numero"]?></p>
                <p><strong>Adresse :</strong><?php echo $user["adresse"]?></p>
		        <p><strong>Interphone :</strong><?php echo $user["interphone"]?></p>
		        <p><strong>Dernière connexion :</strong><?php echo $user["derniere_connexion"]?></p>
		        <p><strong>Age:</strong><?php echo $user["age"]?></p></br>
            </div>

        </div>

        <div class="profil-droite">

            <div class="bloc-droite">
                <h3>Anciennes commandes</h3>
                <?php if(empty($commandesUtilisateur)): ?>
                    <p>Aucune commande enregistrée pour le moment.</p>
                <?php else: ?>
                    <?php foreach($commandesUtilisateur as $commande): ?>
                        <p>
                            <strong><?php echo htmlspecialchars($commande['id']); ?></strong>
                            – <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($commande['date_creation']))); ?>
                            – <?php echo number_format($commande['total'], 2, ',', ''); ?> €
                            – <?php echo htmlspecialchars($commande['statut']); ?>
                        </p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            
            <div class="bloc-droite">
                <h3>Compte fidélité</h3>
                <p><strong>Niveau :</strong> <?php echo htmlspecialchars($user["statut"]); ?></p>
                <p><strong>Points :</strong> 120 pts</p>
                <p>Prochaine récompense :</p>
                <p>-10 % à 150 points</p>
            </div>

        </div>

        <div class="actions-profil">
            <button class="btn-modifier">
                <img src="image/editImage.png" alt="image crayon">
            </button>
            <a href="section/deconnexion.php" class="btn-deco">Déconnexion</a>
            <?php if ($_SESSION["user"]["role"] === "administrateur"): ?>
<form method="post">
    <select name="remise" onchange="this.form.submit()">
        <option value="10%" <?= ($user["remise"] ?? "") === "10%" ? "selected":"" ?>>Remise 10%</option>
        <option value="15%" <?= ($user["remise"] ?? "") === "15%" ? "selected":"" ?>>Remise 15%</option>
        <option value="20%" <?= ($user["remise"] ?? "") === "20%" ? "selected":"" ?>>Remise 20%</option>
    </select>
    <input type="hidden" name="user-id" value="<?= $user["id"] ?>">
</form>
<?php endif; ?>
        </div>

    </div>

</div>

</body>
</html>