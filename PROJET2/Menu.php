<?php 
    session_start();
    include_once("section/Fonction/fonction.php");
    if (!isset($_SESSION["Panier"])) {
        $_SESSION["Panier"] = [];
    }
    if(isset($_POST["Ajouter"])){
        if(isset($_SESSION["user"])){
            if($_POST["Ajouter"] == "Ajouter"){
                $couple = array($_POST["nomAjout"],$_POST["prixAjout"]);
                $_SESSION["Panier"][] = $couple;
            }
            else if($_POST["Ajouter"] == "Supprimer"){
                SupprPanier($_SESSION["Panier"],$_POST["nomSuppr"],$_POST["prixSuppr"]);
            }
        }
        else{
            header("Location: Connexion.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KUNG FOOD - Menu</title>
        <link rel="stylesheet" href="CSS/styleMenu.css">
        <link rel="stylesheet" href="CSS/BarreNav.css">
        <link rel="stylesheet" href="CSS/Recherche.css">
        <link rel="stylesheet" id="theme" href="CSS/Variable.css">
        <link rel="icon" type="image/png" href="image/pandaLogo.png">
        <script src="section/Javascript/filtre.js" defer></script>
        <script src="section/Javascript/theme.js" defer></script>
    </head>
    <body>
        <?php include 'section/Navigation.php'; ?>

        <div class="effetNoir">
            <a href="Panier.php" class="panier">
                <img src="image/panierIcone.png" alt="Icone de panier">
            </a>
            <section class="PosBarre">
                <div class="Titre">
                    <h1>Presentation des plats</h1>
                </div>
                    <?php include 'section/BarreMenu.php'; ?>
            </section>
            <section class="Menu">
                <div class="MenuGrid" id="grillePlat">
                    <?php include 'section/plat.php'; ?>
                </div>
            </section>
            <section class="listeMenu">
                <div class="Titre">
                    <h1>Presentation des Menus</h1>
                </div>
                <section class="Menu">
                    <div class="MenuGrid" id="grilleMenu">
                        <?php include 'section/menus.php'; ?>
                    </div>
                </section>
            </section>
        </div>
    </body>
</html>