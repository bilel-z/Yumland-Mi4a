<?php 
    session_start();
    include_once("section/Fonction/fonction.php");
    //On initialise le panier s'il n'existe pas encore en session
    if (!isset($_SESSION["Panier"])) {
        $_SESSION["Panier"] = [];
    }
    //On traite les données si le bouton Ajouter ou Supprimer a été cliqué
    if(isset($_POST["Ajouter"])){
        //On vérifie que l'utilisateur est bien connecté
        if(isset($_SESSION["user"])){
            if($_POST["Ajouter"] == "Ajouter"){
                //On ajoute le plat au panier avec son nom et son prix
                $couple = array($_POST["nomAjout"],$_POST["prixAjout"]);
                $_SESSION["Panier"][] = $couple;
            }
            else if($_POST["Ajouter"] == "Supprimer"){
                //On retire une fois le plat du panier
                SupprPanier($_SESSION["Panier"],$_POST["nomSuppr"],$_POST["prixSuppr"]);
            }
            //Empêche le renvoie du formulaire quand on recharge la page
            header("Location: Menu.php");
            exit;
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
    <script src="section/Javascript/check_bloque.js" defer></script>
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