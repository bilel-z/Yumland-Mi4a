<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Connexion</title>
    <link rel="stylesheet" href="CSS/Connexion.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'Navigation.php'; ?>

<div class="Teinte"></div>

<main class="login-wrapper">
    <div class="login-box">

       
        <h2 class="titre-principal">Bienvenue</h2>
        <p class="sous-titre">Connectez-vous pour accéder à votre espace</p>

        <form>
            <label>Email</label>
            <input type="email" placeholder="exemple@email.com" required>

            <label>Mot de passe</label>
            <input type="password" placeholder="••••••••" required>

            <button type="submit">Se connecter</button>

            <a href="Inscription.html" class="inscrire">Créer un compte</a>
        </form>

    </div>
</main>

</body>
</html>
