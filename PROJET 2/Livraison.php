<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Livraison</title>
    <link rel="stylesheet" href="CSS/Livraison.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
    <body>

        <?php include 'section/Navigation.php'; ?>

        <div class="Teinte"></div>

        <div class="centrage">
            <div class="carte-blanche">

                <h2>Livraison – Interface Livreur</h2>
                <h3>Commande #245</h3>

                <div class="Livraison-contenu">

                    <div class="Livraison-info">
                        <p><strong>Adresse :</strong><br>12 rue de Pékin, 75013 Paris</p>
                        <p><strong>Code interphone :</strong> 2589</p>
                        <p><strong>Étage :</strong> 4</p>
                        <p><strong>Téléphone :</strong><br>06 12 34 56 78</p>
                        <p><strong>Commentaires :</strong><br>
                        Merci de m’appeler en bas, l’ascenseur est en panne.</p>
                    </div>

                    <div class="mapss">
                        <div class="image-maps"></div>
                        <a
                        href="https://www.google.com/maps/search/?api=1&query=25+rue+Nationale+75013+Paris"
                        class="maps"
                        target="_blank">
                        Ouvrir dans Maps
                        </a>
                    </div>

                </div>

                <button class="LivraisonTerminee">Livraison terminée</button>

            </div>
        </div>

    </body>
</html>
