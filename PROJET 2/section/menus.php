<?php 

    $menu = json_decode(file_get_contents('section/JSON/plats.json'), true);

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
                            <button class="AjouterPanier">Ajouter</button>
                        </div>
                    </div>
                </div>
            ';
        }
    }

?>
