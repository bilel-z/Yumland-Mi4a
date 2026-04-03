<?php 
    include_once("section/Fonction/fonction.php");
    $liste = listeUnique($_SESSION["Panier"]);

    foreach($liste as $plat){
        $nb = ComptePanier($_SESSION["Panier"],$plat["nom"]);
        echo '
            <div class="boitePlatPanier">
                <div class="gaucheBoitePanier">
                    <div class="nomPlatPanier">'.$plat["nom"].'</div>
                </div>
                <div class="droiteBoitePanier">
                    <div class="prixPlatPanier">x'.$nb.'</div>
                    <div class="prixPanier">'.number_format($plat["prix"]*$nb,2,',','').' €</div>
                    <form method="post">
                        <input type="hidden" name="nomSuppr" value="'.$plat["nom"].'" >
                        <input type="hidden" name="Ajouter" value="Supprimer" >
                        <button type="submit" class="retirerPlatPanier">-</button>
                    </form>
                </div>
            </div>
        ';
    }

?>