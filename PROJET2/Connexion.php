<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Connexion</title>
    <link rel="stylesheet" href="CSS/Connexion.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
<body>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["Mail"];
    $password = $_POST["Mdp"];

    $file = "section/JSON/utilisateurs.json";

   

        if (file_exists($file)) {
        $users = json_decode(file_get_contents($file), true);

        foreach ($users as &$user) { 
	if ($user["Mail"] === $email && $user["Mdp"] === $password) {
    		if ($user["bloquer"] === true) {
        	$error= "Votre compte a été bloqué, veuillez contacter l'administrateur.";
        	break;
    		}
    		$user["derniere_connexion"] = date("Y-m-d H:i:s");
    		$_SESSION["user"] = $user;
    		file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    		if ($user["role"] == "client") {
        	header("Location: Acceuil.php");
    	} elseif ($user["role"] == "livreur") {
        	header("Location: Livraison.php");
    	} elseif ($user["role"] == "restaurateur") {
        	header("Location: commandes.php");
    	} elseif ($user["role"] == "administrateur") {
        	header("Location: Admin.php");
    	}
    	exit();
	}
	if ($user["Mail"] !== $email || $user["Mdp"] !== $password) {
		$error= "Email ou mot de passe incorrect";
	}
    }
	
}
}

?>
<?php include 'section/Navigation.php'; ?>
<div class="Teinte"></div>

<main class="login-wrapper">
    <div class="login-box">

       
        <h2 class="titre-principal">Bienvenue</h2>
        <p class="sous-titre">Connectez-vous pour accéder à votre espace</p>

        <form method="POST" action="">
            <label>Email</label>
    <input type="email" name="Mail" placeholder="exemple@email.com" required>

    <label>Mot de passe</label>
    <input type="password" name="Mdp" placeholder="••••••••" required>

            <button type="submit">Se connecter</button>
	<?php if (!empty($error)): ?>
    <p class="erreur"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
            <a href="Inscription.php" class="inscrire">Créer un compte</a>
        </form>

    </div>
</main>

</body>
</html>
