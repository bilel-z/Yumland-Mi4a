<?php session_start(); 
include_once("section/Fonction/fonction.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newUser = [
        "id" => time(),
        "Nom" => $_POST["Nom"],
        "Prenom" => $_POST["Prenom"],
        "Mail" => $_POST["Mail"],
        "Mdp" => $_POST["Mdp"],
        "age" => $_POST["Age"],
        "numero" => $_POST["Num"],
        "adresse" => $_POST["Adresse"],
        "interphone" => $_POST["Interphone"],
        "role" => "client",
        "date_inscription" => date("Y-m-d"),
        "derniere_connexion" => date("Y-m-d H:i:s"),
        "statut" => "Classique",
        "bloquer"=> false,
        "Commandes" => []
    ];

    $file = "section/JSON/utilisateurs.json";

    if (file_exists($file)) {
        $users = lireJson($file);
    } else {
        $users = [];
    }

    $users[] = $newUser;

    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

    header("Location: Acceuil.php");
    exit();
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
                <form method="post">
                    <div class="TitreInscription">
                        <h4>INSCRIPTION</h4>
                    </div>
                    <div class="ChampsInscription">
                        <label for="NomFor">Nom</label>
                        <input id="NomFor" name="Nom" placeholder="Martin" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="PrenomFor">Prenom</label>
                        <input id="PrenomFor" name="Prenom" placeholder="Jean" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="MailFor">Email</label>
                        <input type="email" id="MailFor" name="Mail" placeholder="exemple@email.com" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="MdpFor">Mot de passe</label>
                        <input type="password" id="MdpFor" name="Mdp" placeholder="••••••••" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="AgeFor">Date de naissance</label>
                        <input type="date" id="AgeFor" name="Age" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="NumFor">Numéro de téléphone</label>
                        <input id="NumFor" name="Num" placeholder="06••••••••" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="AdresseFor">Adresse</label>
                        <input id="AdresseFor" name="Adresse" placeholder="12 rue de Pékin, 75013 Paris" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="InterphoneFor">Code d'interphone (facultatif)</label>
                        <input id="InterphoneFor" name="Interphone" placeholder="2589">
                    </div>
                    <div class="envoi">
                        <input class="StyleEnvoi" type="submit" name="Boutton envoi" value="Envoyer">
                    </div>
                </form>
            </div>
        </section>
        <footer>
            <div>Ⓒ COPYRIGHTY 2026 - Mentions légales</div>
        </footer>
    </body>
</html>