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
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
    <script src="section/Javascript/theme.js" defer></script>
    <script src="section/Javascript/profil.js" defer></script>
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
?>
<?php include 'section/Navigation.php'; ?>

<div class="Teinte"></div>

<div class="centrage">

    <div class="carte-blanche profil-global">

        <div class="profil-gauche">

            <div class="photo-profil">
                <img src="image/pdp.png" alt="Photo de profil">
            </div>

            <h2 id="titreProfil"><?php echo htmlspecialchars($user["Nom"] . ' ' . $user["Prenom"]); ?></h2>
            <div class="infos-profil">
                <p id="champsPrenom" class="lecture"><strong>Prenom :</strong> <?php echo $user["Prenom"]?></p>
                <label class="edition" for="changerPrenom">Prenom :</label>
                <input class="edition champsEdition" id="changerPrenom" type="text" value="<?php echo $user["Prenom"] ?>">

                <p id="champsNom" class="lecture"><strong>Nom :</strong> <?php echo $user["Nom"]?></p>
                <label class="edition" for="changerNom">Nom :</label>
                <input class="edition champsEdition" id="changerNom" type="text" value="<?php echo $user["Nom"] ?>">

                <p id="champsMail" class="lecture"><strong>Email :</strong> <?php echo $user["Mail"]?></p>
                <label class="edition" for="changerMail">Email :</label>
                <input class="edition champsEdition" id="changerMail" type="email" value="<?php echo $user["Mail"] ?>">

                <p id="champsNum" class="lecture"><strong>Téléphone :</strong> <?php echo $user["numero"]?></p>
                <label class="edition" for="changerNumero">Téléphone :</label>
                <input class="edition champsEdition" id="changerNumero" type="tel" value="<?php echo $user["numero"] ?>">

                <p id="champsAdresse" class="lecture"><strong>Adresse :</strong><?php echo $user["adresse"]?></p>
                <label class="edition" for="changerAdresse">Adresse :</label>
                <input class="edition champsEdition" id="changerAdresse" type="text" value="<?php echo $user["adresse"] ?>">

                <p id="champsInterphone" class="lecture"><strong>Interphone :</strong><?php echo $user["interphone"]?></p>
                <label class="edition" for="changerInterphone">Interphone :</label>
                <input class="edition champsEdition" id="changerInterphone" type="text" value="<?php echo $user["interphone"] ?>">

                <p id="champsAge" class="lecture"><strong>Date de naissance:</strong><?php echo $user["age"]?></p>
                <label class="edition" for="changerAge">Date de naissance :</label>
                <input class="edition champsEdition" id="changerAge" type="date" value="<?php echo $user["age"] ?>">

                <p class="lecture"><strong>Dernière connexion :</strong><?php echo $user["derniere_connexion"]?></p></br>

            </div>

        </div>

        <div class="actions-profil">
            <button class="btn-modifier lecture" id="bouttonModifier" onclick="modeEdition();">
                <img src="image/editImage.png" alt="image crayon">
            </button>
            <button class="edition" id="validerProfil" onclick="modifierProfil();">Valider</button>
            <button class="edition" id="annulerProfil" onclick="modeLecture();">Annuler</button>
            <a href="section/deconnexion.php" class="btn-deco lecture">Déconnexion</a>
        </div>

    </div>

</div>

</body>
</html>
