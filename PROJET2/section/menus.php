<?php 
    session_start();
    include_once(__DIR__ . "/Fonction/fonction.php");
    $menu = lireJson(__DIR__ . "/JSON/plats.json");
    if (!isset($_SESSION["Panier"])) {
        $_SESSION["Panier"] = [];
    }

    foreach($menu as $plat){

        $affiche = true;

        if($plat['categorie'] != "Menu"){
            $affiche = false;
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

        if($affiche){
            echo '
                <div class="BoitePlat">
                    <div class="BoiteContenu">
                        <h3>'.$plat["nom"].'</h3>
                        <p>- '.$plat["Composition"][0].'<br>- '.$plat["Composition"][1].'<br>- '.$plat["Composition"][2].'<br>- '.$plat["Composition"][3].'</p>
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
