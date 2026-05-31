<?php
session_start();

//On vide la session, on supprime le cookie et on redirige vers la connexion
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
}

session_destroy();

header('Location: ../Connexion.php');
exit();
?>