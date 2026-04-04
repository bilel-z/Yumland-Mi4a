<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <div class="logo">
        <img src="image/pandaLogo.png" alt="Logo restaurant panda" />
    </div>
    <div class="navigation">
        <ul>
            <li>
                <a href="Acceuil.php">Accueil</a>
            </li>
            <li>
                <a href="Menu.php">Menu</a>
            </li>
            <li>
                <a href="Connexion.php">Connexion</a>
            </li>
            <li>
                <a href="Profil.php">Profil</a>
            </li>
            <li>
                <a href="Livraison.php">Livraison</a>
            </li>
            <li>
                <a href="Note.php">Notez-nous</a>
            </li>

            <?php if (isset($_SESSION["user"]) && isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "client"): ?>
                <li>
                    <a href="Historique.php">Historique</a>
                </li>
            <?php endif; ?>

            <?php if (isset($_SESSION["user"]) && isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "restaurateur"): ?>
                <li>
                    <a href="Gestion.php">Gestion</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>