<?php 
    session_start();
    include_once("section/Fonction/fonction.php");
    if(isset($_POST["Ajouter"]) && $_POST["Ajouter"] == "Supprimer"){
        if(isset($_POST["nomSuppr"])){
            $nom = $_POST["nomSuppr"];
            foreach($_SESSION["Panier"] as $plat){
                if($plat[0] == $nom){
                    $prix = $plat[1];
                    break;
                }
            }
            SupprPanier($_SESSION["Panier"], $nom, $prix);
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
        <link rel="stylesheet" href="CSS/Variable.css">
        <link rel="stylesheet" href="CSS/Panier.css">
        <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
    </head>
    <body>
        <?php include 'section/Navigation.php'; ?>
        <div class="effetNoir">
            <section class="TitrePanier">
                <div class="Titre">
                    <h1>Panier</h1>
                </div>
                <div class="nbPlat">
                    <?php echo count($_SESSION["Panier"]).' Articles'; ?>
                </div>
            </section>
            <section class="panierCommande">
                <div class="panierPlat">
                    <?php include('section/elementPanier.php'); ?>
                </div>
                <div class="panierPayer">
                    <div class="espacePaye">
                        <div class="surPayer">
                            <div>Nombre d'articles</div>
                            <div><?php echo count($_SESSION["Panier"]) ?></div>
                        </div>
                        <div class="surPayer">
                            <div><b>Total</b></div>
                            <div class="prixPanier"><?php echo number_format(total($_SESSION["Panier"]),2,',','').' €'; ?></div>
                        </div>
                    </div>
                    <div class="payer">
                        <form method="post">
                            <button type="submit">Commander</button>
                        </form>
                        <a href="Menu.php">Continuer les achats</a>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>