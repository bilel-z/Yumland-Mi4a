<?php 
    session_start();
    include_once(__DIR__ . "/Fonction/fonction.php");
    //On initialise le panier s'il n'existe pas
    if (!isset($_SESSION["Panier"])) {
        $_SESSION["Panier"] = [];
    }
    //On charge tous les plats depuis le JSON et on parcourt chaque plat pour décider s'il doit être affiché en fonction des filtres
    $menu = lireJson(__DIR__ . '/JSON/plats.json');

    foreach($menu as $plat){

        $affiche = true;
        //On exclut les menus
        if($plat['categorie'] == "Menu"){
            $affiche = false;
        }

        if(!empty($_GET['typePlat'])){
            if($_GET['typePlat'] != $plat['categorie']){
                $affiche = false;
            }
        }
        if(!empty($_GET['Allergene'])){
            if(!(in_array($_GET['Allergene'], $plat['filtres']))){
                $affiche = false;
            }
        }
        if(!empty($_GET['typeSaveur'])){
            if(!(in_array($_GET['typeSaveur'], $plat['filtres']))){
                $affiche = false;
            }
        }

        //On filtre grâce à la recherche sur le nom du plat
        if(!empty($_GET['recherche'])){
            $resultat = strtolower(trim($_GET['recherche']));
            if(strpos(strtolower($plat['nom']), $resultat) === false){
                $affiche = false;
            }
        }

        //On affiche la carte du plat s'il passe tous les filtres
        if($affiche){
            echo '
                <div class="BoitePlat" data-prix="'.$plat["prix"].'" data-nbcommande="'.($plat["commandes"] ?? 0).'">
                    <div class="PlatImage">
                        <img src="'.$plat["image"].'" alt="Image '.$plat["nom"].'" />
                    </div>
                    <div class="BoiteContenu">
                        <h3>'.$plat["nom"].'</h3>
                        <p class="description">'.$plat["description"].'</p>
                        <div class="AjoutPanier">
                            <span class="prix">'.number_format($plat["prix"], 2, ',', '').'</span>
                            <form method="post">
                                <input type="hidden" name="nomAjout" value="'.$plat["nom"].'" >
                                <input type="hidden" name="prixAjout" value="'.$plat["prix"].'" >
                                <input type="hidden" name="Ajouter" value="Ajouter" >
                                <button type="submit" class="AjouterPanier">Ajouter</button>
                            </form>';
                            if(in_array(array($plat["nom"],$plat["prix"]),$_SESSION["Panier"])){
                                echo '
                                <form method="post">
                                    <input type="hidden" name="nomSuppr" value="'.$plat["nom"].'" >
                                    <input type="hidden" name="prixSuppr" value="'.$plat["prix"].'" >
                                    <input type="hidden" name="Ajouter" value="Supprimer" >
                                    <button type="submit" class="AjouterPanier">Retirer 1 ('.ComptePanier($_SESSION["Panier"],$plat["nom"]).')</button>
                                </form>
                                ';
                            }
                        echo '</div>
                    </div>
                </div>
            ';
        }
    }

?>
