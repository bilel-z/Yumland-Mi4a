<?php
include_once("section/Fonction/fonction.php");
securiserCookieSession();
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: Connexion.php");
    exit();
}

if (isset($_GET["id"])) {
    if (($_SESSION["user"]["role"] ?? "") !== "administrateur") {
        header("Location: Profil.php");
        exit();
    }
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
   <script src="section/Javascript/validation.js"></script>
   <script src="section/Javascript/profil.js"></script>
</head>
<script src="section/Javascript/check_bloque.js" defer></script>


<body>

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
                <p id="champsPrenom" class="lecture"><strong>Prenom :</strong> <?php echo echapper($user["Prenom"]); ?></p>
                <label class="edition" for="changerPrenom">Prenom :</label>
                <input class="edition champsEdition" id="changerPrenom" type="text" value="<?php echo echapper($user["Prenom"]); ?>">
		<span id="compteur-prenom" class="compteur-texte"></span>
                <span class="messageErreur" id="prenomErreur"></span>

                <p id="champsNom" class="lecture"><strong>Nom :</strong> <?php echo echapper($user["Nom"]); ?></p>
                <label class="edition" for="changerNom">Nom :</label>
                <input class="edition champsEdition" id="changerNom" type="text" value="<?php echo echapper($user["Nom"]); ?>">
		<span id="compteur-nom" class="compteur-texte"></span>
                <span class="messageErreur" id="nomErreur"></span>

                <p id="champsMail" class="lecture"><strong>Email :</strong> <?php echo echapper($user["Mail"]); ?></p>
                <label class="edition" for="changerMail">Email :</label>
                <input class="edition champsEdition" id="changerMail" type="email" value="<?php echo echapper($user["Mail"]); ?>"maxlength="100" data-compteur="compteur-mail">
		<span id="compteur-mail" class="edition champsEdition" class="compteur-texte"></span>
                <span class="messageErreur" id="mailErreur"></span>

                <p id="champsNum" class="lecture"><strong>Téléphone :</strong> <?php echo echapper($user["numero"]); ?></p>
                <label class="edition" for="changerNumero">Téléphone :</label>
                <input class="edition champsEdition" id="changerNumero" type="tel" value="<?php echo echapper($user["numero"]); ?>">
                <span class="messageErreur" id="numErreur"></span>

                <p id="champsAdresse" class="lecture"><strong>Adresse :</strong><?php echo echapper($user["adresse"]); ?></p>
                <label class="edition" for="changerAdresse">Adresse :</label>
                <input class="edition champsEdition" id="changerAdresse" type="text" value="<?php echo echapper($user["adresse"]); ?>">
                <span class="messageErreur" id="adresseErreur"></span>

                <p id="champsInterphone" class="lecture"><strong>Interphone :</strong><?php echo echapper($user["interphone"]); ?></p>
                <label class="edition" for="changerInterphone">Interphone (optionnel) :</label>
                <input class="edition champsEdition" id="changerInterphone" type="text" value="<?php echo echapper($user["interphone"]); ?>">
                <span class="messageErreur" id="interphoneErreur"></span>

                <p id="champsAge" class="lecture"><strong>Date de naissance:</strong><?php echo echapper($user["age"]); ?></p>
                <label class="edition" for="changerAge">Date de naissance :</label>
                <input class="edition champsEdition" id="changerAge" type="date" value="<?php echo echapper($user["age"]); ?>">
                <span class="messageErreur" id="ageErreur"></span>

                <br class="edition">
                <h3 class="edition" >Modifier le mot de passe (optionnel)</h3>

                <label class="edition" for="changerAncienMDP">Ancien mot de passe :</label>
                <input class="edition champsEdition" id="changerAncienMDP" type="password" maxlength="30" data-compteur="compteur-ancien-mdp" value="" placeholder="••••••••" autocomplete="new-password">
		<span id="compteur-ancien-mdp" class="edition champsEdition" class="compteur-texte"></span>
                <button type="button" id="togglePassword" class="edition">👁️</button>
                
                <label class="edition" for="changerNouveauMDP">Nouveau mot de passe :</label>
                <input class="edition champsEdition" id="changerNouveauMDP" type="password" maxlength="30" data-compteur="compteur-nouveau-mdp" value="" placeholder="••••••••" autocomplete="new-password">
		<span id="compteur-nouveau-mdp" class="edition champsEdition" class="compteur-texte"></span>
                <button type="button" id="togglePassword1" class="edition">👁️</button>
                
                <label class="edition" for="changerConfirmeMDP">Confirmation du nouveau mot de passe :</label>
                <input class="edition champsEdition" id="changerConfirmeMDP" type="password" maxlength="30" data-compteur="compteur-confirmation-mdp" value="" placeholder="••••••••" autocomplete="new-password">
		<span id="compteur-confirmation-mdp" class="edition champsEdition" class="compteur-texte"></span>
                <button type="button" id="togglePassword2" class="edition">👁️</button>
                <span id="mdpErreur" class="messageErreur edition"></span>

                <p class="lecture"><strong>Dernière connexion :</strong><?php echo echapper($user["derniere_connexion"]); ?></p></br>

            </div>

        </div>

        <div class="actions-profil">
            <?php if(!isset($_GET["id"])): ?>
                <button class="btn-modifier lecture" id="bouttonModifier" onclick="modeEdition();">
                    <img src="image/editImage.png" alt="image crayon">
                </button>
                <button class="edition" id="validerProfil" onclick="modifierProfil();">Valider</button>
                <button class="edition" id="annulerProfil" onclick="modeLecture();">Annuler</button>
            <?php endif;?>
            <a href="section/deconnexion.php" class="btn-deco lecture">Déconnexion</a>
        </div>

    </div>

</div>
<script src="section/Javascript/compteur.js"></script>
</body>
</html>