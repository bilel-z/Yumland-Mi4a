<?php session_start(); 
include_once("section/Fonction/fonction.php");
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'livreur') {
    header('Location: Connexion.php');
    exit();
}
if(isset($_POST["Livraison"])){
    $commande = lireJson("section/JSON/commandes.json");
    foreach($commande as &$c){
        if($c["livreur_id"] == $_SESSION["user"]["id"] && $c["statut"] == "en livraison"){
            if($_POST["Livraison"]=="oui"){
                $c["statut"] = "livrée";
            }
            else if($_POST["Livraison"]=="non"){
                $c["statut"] = "abondonnée";
            }
            $c["date_retrait_livraison"] = date("Y-m-d H:i:s");
            break;
        }
    }
    unset($c);
    ecrireJson("section/JSON/commandes.json", $commande);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Livraison</title>
    <link rel="stylesheet" href="CSS/Livraison.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
    <body>

        <?php include 'section/Navigation.php'; ?>

        <div class="Teinte"></div>

        <div class="centrage">
            <div class="carte-blanche">

            <?php
                $commandes = lireJson("section/JSON/commandes.json");
                $livraison = null;
                foreach($commandes as $c){
                    if($c["livreur_id"] == $_SESSION["user"]["id"] && $c["statut"] == "en livraison"){
                        $livraison = $c;
                        break;
                    }
                }
            ?>

                <h2>Livraison – Interface Livreur</h2>
                <h3>Commande <?php echo ($livraison !== null) ? $livraison["id"] : "Aucune commande";?></h3>

                <div class="Livraison-contenu">

                    <div class="Livraison-info">
                        <p><strong>Adresse :</strong><br><?php echo ($livraison !== null) ? $livraison["adresse_livraison"] : "";?></p>
                        <p><strong>Interphone :</strong> <?php echo ($livraison !== null) ? $livraison["client_interphone"] : "";?></p>
                        <p><strong>Téléphone :</strong><br><?php echo ($livraison !== null) ? $livraison["client_telephone"] : "";?></p>
                        <p><strong>Commentaires : </strong><br>
                        <?php echo ($livraison !== null) ? $livraison["commentaire"] : "";?></p>
                    </div>

                    <div class="mapss">
                        <div class="image-maps"></div>
                        <a
                        href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($livraison['adresse_livraison'] ?? ''); ?>"
                        class="maps"
                        target="_blank">
                        Ouvrir dans Maps
                        </a>
                    </div>

                </div>
                <?php 
                if($livraison !== null){
                echo'
                <form method="post">
                    <input type="hidden" name="Livraison" value="oui">
                    <button type="submit" class="LivraisonTerminee">Livraison terminée</button>
                </form>
                '; 
                }?>
                <?php 
                if($livraison !== null){
                echo'
                <form method="post">
                    <input type="hidden" name="Livraison" value="non">
                    <button type="submit" class="LivraisonTerminee">Livraison abondonnée</button>
                </form>
                '; 
                }?>
                
            </div>
        </div>

    </body>
</html>
