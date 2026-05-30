<?php
include_once("section/Fonction/fonction.php");
securiserCookieSession();
session_start();
$error = "";
if (isset($_SESSION["user"])) {
    header("Location: Profil.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!requeteInterne()) { http_response_code(403); exit("Requête refusée."); }
    $email = nettoyerEntree($_POST["Mail"] ?? "", 100);
    $password = (string)($_POST["Mdp"] ?? "");
    $file = "section/JSON/utilisateurs.json";
    if (file_exists($file)) {
        $users = lireJson($file);
        $error = "Email ou mot de passe incorrect";
        foreach ($users as &$user) { 
            if ($user["Mail"] === $email && password_verify($password, $user["Mdp"])) {
                if ($user["bloquer"] === true) {
                    $error = "Votre compte a été bloqué, veuillez contacter l'administrateur.";
                    break;
                }
                $user["derniere_connexion"] = date("Y-m-d H:i:s");
                session_regenerate_id(true);
                $_SESSION["user"] = $user;
                file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
                if ($user["role"] == "client") {
                    header("Location: Acceuil.php");
                } elseif ($user["role"] == "livreur") {
                    header("Location: Livraison.php");
                } elseif ($user["role"] == "restaurateur") {
                    header("Location: Gestion.php");
                } elseif ($user["role"] == "administrateur") {
                    header("Location: Admin.php");
                }
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Connexion</title>
    <link rel="stylesheet" href="CSS/Connexion.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
    <script src="section/Javascript/theme.js" defer></script>
	<script src="section/Javascript/validation.js" defer></script>
</head>

<body>
<?php include 'section/Navigation.php'; ?>
<div class="Teinte"></div>
<main class="login-wrapper">
    <div class="login-box">
        <h2 class="titre-principal">Bienvenue</h2>
        <p class="sous-titre">Connectez-vous pour accéder à votre espace</p>
        <form method="POST" action="" id="loginForm">
            <label>Email</label>
            <input type="email" name="Mail" id="email" placeholder="exemple@email.com" maxlength="100" data-compteur="compteur-mail" required>
            <span id="compteur-mail" class="compteur-texte"></span>
            <span class="messageErreur" id="erreurEmail"></span>

            <label>Mot de passe</label>
            <div class="champ-mdp">
                <input type="password" name="Mdp" id="mdp" placeholder="••••••••" maxlength="30" data-compteur="compteur-mdp" required>
                <button type="button" id="togglePassword">👁️</button>
            </div>
            <span id="compteur-mdp" class="compteur-texte"></span>
            <span class="messageErreur" id="erreurMdp"></span>

            <button type="submit">Se connecter</button>
            <?php if (!empty($error)): ?>
                <b><p class="erreur"><?= htmlspecialchars($error) ?></p></b>
            <?php endif; ?>
            <a href="Inscription.php" class="inscrire">Créer un compte</a>
        </form>
    </div>
<script src="section/Javascript/compteur.js"></script>
</main>

</body>
</html>