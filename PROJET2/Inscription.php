<?php session_start(); 
include_once("section/Fonction/fonction.php");
$doublonMail = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newUser = [
        "id" => time(),
        "Nom" => $_POST["Nom"],
        "Prenom" => $_POST["Prenom"],
        "Mail" => $_POST["Mail"],
        "Mdp" => password_hash($_POST["Mdp"], PASSWORD_DEFAULT),
        "age" => $_POST["Age"],
        "numero" => $_POST["Num"],
        "adresse" => $_POST["Adresse"],
        "interphone" => $_POST["Interphone"],
        "role" => "client",
        "date_inscription" => date("Y-m-d"),
        "derniere_connexion" => date("Y-m-d H:i:s"),
        "statut" => "Classique",
        "bloquer"=> false,
        "Commandes" => [],
        "plats_gratuits" => 0
    ];

    $file = "section/JSON/utilisateurs.json";

    if (file_exists($file)) {
        $users = lireJson($file);
    } else {
        $users = [];
    }
    foreach($users as $element){
        if($element["Mail"] === $_POST["Mail"]){
            $doublonMail = 1;
            break;
        }
    }

    if(!$doublonMail){
        $users[] = $newUser;
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
        header("Location: Acceuil.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KUNG FOOD - Inscription</title>
        <link rel="stylesheet" href="CSS/styleInscription.css">
        <link rel="stylesheet" href="CSS/BarreNav.css">
        <link rel="stylesheet" id="theme" href="CSS/Variable.css">
        <link rel="icon" type="image/png" href="image/pandaLogo.png">
        <script src="section/Javascript/theme.js" defer></script>
    </head>
    <body>

<?php include 'section/Navigation.php'; ?>
        <section>
            <div class="logoInscription">
                <img src="image/pandaLogo.png" alt="Logo restaurant panda" />
                <h2>KUNG FOOD</h2>
            </div>
            <div class="BoiteForm">
                <form method="post" id="inscriptionForm">
                    <div class="TitreInscription">
                        <h4>INSCRIPTION</h4>
                    </div>
                    <div class="ChampsInscription">
                        <label for="NomFor">Nom</label>
                        <input id="NomFor" name="Nom" placeholder="Martin" required="required">
                        <span class="messageErreur" id="erreurNom"></span>
                    </div>
                    <div class="ChampsInscription">
                        <label for="PrenomFor">Prenom</label>
                        <input id="PrenomFor" name="Prenom" placeholder="Jean" required="required">
                        <span class="messageErreur" id="erreurPrenom"></span>
                    </div>
                    <div class="ChampsInscription">
                        <label for="MailFor">Email</label>
                        <input type="email" id="MailFor" name="Mail" placeholder="exemple@email.com" maxlength="100" data-compteur="compteur-mail" required="required">
                        <span id="compteur-mail" class="compteur-texte"></span>
                        <span class="messageErreur" id="erreurEmail"></span>
                    </div>
                    <div class="ChampsInscription">
                        <label for="MdpFor">Mot de passe</label>
                        <input type="password" id="MdpFor" name="Mdp" placeholder="••••••••" maxlength="30" data-compteur="compteur-mdp" required="required">
                        <button type="button" id="togglePassword">👁️</button>
                        <span id="compteur-mdp" class="compteur-texte"></span>
                        <span class="messageErreur" id="erreurMdp"></span>
                    </div>
                    <div class="ChampsInscription">
                        <label for="AgeFor">Date de naissance</label>
                        <input type="date" id="AgeFor" name="Age" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="NumFor">Numéro de téléphone</label>
                        <input type="tel" id="NumFor" name="Num" placeholder="06••••••••" maxlength="10" data-compteur="compteur-num" required="required">
                        <span id="compteur-num" class="compteur-texte"></span>
                        <span class="messageErreur" id="erreurNum"></span>
                    </div>
                    <div class="ChampsInscription">
                        <label for="AdresseFor">Adresse</label>
                        <input id="AdresseFor" name="Adresse" placeholder="12 rue de Pékin, 75013 Paris" required="required">
                        <span class="messageErreur" id="erreurAdresse"></span>
                    </div>
                    <div class="ChampsInscription">
                        <label for="InterphoneFor">Code d'interphone (facultatif)</label>
                        <input id="InterphoneFor" name="Interphone" placeholder="2589">
                        <span class="messageErreur" id="erreurInterphone"></span>
                    </div>
                    <div class="envoi">
                        <input class="StyleEnvoi" type="submit" name="Boutton envoi" value="Envoyer">
                    </div>
                    <?php if($doublonMail){echo '<b><p class="erreur">Erreur : Le compte associé à cette adresse mail existe déjà.</p></b>';} ?>
                </form>
            </div>
        </section>
        <footer>
            <div>Ⓒ COPYRIGHTY 2026 - Mentions légales</div>
        </footer>
    <script src="section/Javascript/compteur.js"></script>
    <script src="section/Javascript/validation.js"></script>
    </body>
</html>