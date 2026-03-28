<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KUNG FOOD - Inscription</title>
        <link rel="stylesheet" href="CSS/styleInscription.css">
        <link rel="stylesheet" href="CSS/BarreNav.css">
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
                        <input id="NomFor" name="Nom" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="PrenomFor">Prenom</label>
                        <input id="PrenomFor" name="Prenom" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="MailFor">Email</label>
                        <input type="email" id="MailFor" name="Mail" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="MdpFor">Mot de passe</label>
                        <input type="password" id="MdpFor" name="Mdp" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="AgeFor">Date de naissance</label>
                        <input type="date" id="AgeFor" name="Age" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="NumFor">Numéro de téléphone</label>
                        <input id="NumFor" name="Num" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="AdresseFor">Adresse</label>
                        <input id="AdresseFor" name="Adresse" required="required">
                    </div>
                    <div class="ChampsInscription">
                        <label for="InterphoneFor">Numéro d'interphone (facultatif)</label>
                        <input id="InterphoneFor" name="Interphone">
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