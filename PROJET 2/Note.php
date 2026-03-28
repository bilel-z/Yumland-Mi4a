<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notez notre restaurant</title>
    <link rel="stylesheet" href="CSS/styleNotation.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" href="CSS/Variable.css">
</head>
<body>
	<?php include 'section/Navigation.php'; ?>
    <div class="Teinte"></div>
    <section>
	<div class="logoInscription">
                <img src="image/pandaLogo.png" alt="Logo restaurant panda" />
                <h2>KUNG FOOD</h2>
            </div>
<div class="Formulaire">
	<form method="post">
    <fieldset>

        <h1>Notez notre restaurant</h1>


        <div class="ligne-note">
            <p>Service :</p>
            <div class="notation">
                <input type="radio" id="service5" name="service" value="5">
                <label for="service5">★</label>

                <input type="radio" id="service4" name="service" value="4">
                <label for="service4">★</label>

                <input type="radio" id="service3" name="service" value="3">
                <label for="service3">★</label>

                <input type="radio" id="service2" name="service" value="2">
                <label for="service2">★</label>

                <input type="radio" id="service1" name="service" value="1">
                <label for="service1">★</label>
            </div>
        </div>


        <div class="ligne-note">
            <p>Qualité des plats :</p>
            <div class="notation">
                <input type="radio" id="qualite5" name="qualite" value="5">
                <label for="qualite5">★</label>

                <input type="radio" id="qualite4" name="qualite" value="4">
                <label for="qualite4">★</label>

                <input type="radio" id="qualite3" name="qualite" value="3">
                <label for="qualite3">★</label>

                <input type="radio" id="qualite2" name="qualite" value="2">
                <label for="qualite2">★</label>

                <input type="radio" id="qualite1" name="qualite" value="1">
                <label for="qualite1">★</label>
            </div>
        </div>


        <div class="ligne-note">
            <p>Ambiance :</p>
            <div class="notation">
                <input type="radio" id="ambiance5" name="ambiance" value="5">
                <label for="ambiance5">★</label>

                <input type="radio" id="ambiance4" name="ambiance" value="4">
                <label for="ambiance4">★</label>

                <input type="radio" id="ambiance3" name="ambiance" value="3">
                <label for="ambiance3">★</label>

                <input type="radio" id="ambiance2" name="ambiance" value="2">
                <label for="ambiance2">★</label>

                <input type="radio" id="ambiance1" name="ambiance" value="1">
                <label for="ambiance1">★</label>
            </div>
        </div>

   
        <div class="commentaire">
            <label for="commentaire">Commentaire :</label><br>
            <textarea id="commentaire" name="commentaire" rows="5" cols="40"></textarea>
        </div>

        <br>
        <input type="submit" value="Envoyer la note">

    </fieldset>
</form>
</div>
</section>

</body>
</html>
