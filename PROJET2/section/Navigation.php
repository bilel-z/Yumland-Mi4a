<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$estConnecte = isset($_SESSION["user"]);
$role = $estConnecte ? ($_SESSION["user"]["role"] ?? "") : "";
?>

<nav>
    <div class="logo">
        <img src="image/pandaLogo.png" alt="Logo restaurant panda">
        <button id="bouttonTheme" onclick="changerTheme();">Mode clair ☀️</button>
    </div>

    <div class="navigation">
        <ul>
            <li><a href="Acceuil.php">ACCUEIL</a></li>
            <li><a href="Menu.php">MENU</a></li>
            <?php if (!isset($_SESSION["user"])): ?>
                <li><a href="Connexion.php">CONNEXION</a></li>
            <?php endif; ?>
            
            <?php if (isset($_SESSION["user"])): ?>
                <li><a href="Profil.php">PROFIL</a></li>
            <?php endif; ?>

            <?php if ($role === "livreur"): ?>
                <li><a href="Livraison.php">LIVRAISON</a></li>
            <?php endif; ?>

            <?php if ($role === "client"): ?>
                <li><a href="Note.php">NOTEZ-NOUS</a></li>
            <?php endif; ?>

            <?php if ($role === "client"): ?>
                <li><a href="Historique.php">HISTORIQUE</a></li>
            <?php endif; ?>

            <?php if ($role === "restaurateur"): ?>
                <li><a href="Gestion.php">GESTION</a></li>
            <?php endif; ?>

            <?php if ($role === "administrateur"): ?>
                <li><a href="Admin.php">ADMIN</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>