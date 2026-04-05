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
    </div>

    <div class="navigation">
        <ul>
            <li><a href="Acceuil.php">ACCUEIL</a></li>
            <li><a href="Menu.php">MENU</a></li>
            <li><a href="Connexion.php">CONNEXION</a></li>
            <li><a href="Profil.php">PROFIL</a></li>
            <li><a href="Livraison.php">LIVRAISON</a></li>
            <li><a href="Note.php">NOTEZ-NOUS</a></li>

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