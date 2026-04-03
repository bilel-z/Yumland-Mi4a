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
</head>
<body>
<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: connexion.php");
    exit();
}

$user = $_SESSION["user"];
?>
<?php include 'section/Navigation.php'; ?>

<div class="Teinte"></div>

<div class="centrage">

    <div class="carte-blanche profil-global">

        <div class="profil-gauche">

            <div class="photo-profil">
                <img src="image/pdp.jpeg" alt="Photo de profil">
            </div>

            <h2>Jean Martin</h2>

            <div class="infos-profil">
                <p><strong>Nom :</strong> <?php echo $user[Nom]?></p>
                <p><strong>Email :</strong> <?php echo $user[Mail]?></p>
                <p><strong>Téléphone :</strong> <?php echo $user[numero]?></p>
                <p><strong>Adresse :</strong><?php echo $user[adresse]?></p><br>
            </div>

        </div>

        <div class="profil-droite">

            <div class="bloc-droite">
                <h3>Anciennes commandes</h3>
                <p><strong>Commande #245</strong> – 02/02/2025 – 28,90 €</p>
                <p><strong>Commande #231</strong> – 15/01/2025 – 19,50 €</p>
                <p><strong>Commande #198</strong> – 05/12/2024 – 22,00 €</p>
            </div>

            <div class="bloc-droite">
                <h3>Compte fidélité</h3>
                <p><strong>Points :</strong> 120 pts</p>
                <p>Prochaine récompense :</p>
                <p>-10 % à 150 points</p>
            </div>

        </div>

        <div class="actions-profil">
            <button class="btn-modifier">
                <img src="image/editImage.png" alt="image crayon">
            </button>
            <button class="btn-deco">
                <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </button>
        </div>

    </div>

</div>

</body>
</html>

