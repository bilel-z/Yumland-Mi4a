<?php

    session_start();
    include_once("Fonction/fonction.php");


    //Verifie la connexion de l'utilisateur
    if(!isset($_SESSION['user'])){
        echo json_encode(["erreur" => "L'utilisateur n'est pas connecté"]);
        exit();
    }

    //On tire des symboles au hasard et on verife le résultat
    $symbole = ["panda","nouilles","crevette",'nems'];
    $resultat = [$symbole[array_rand($symbole)],$symbole[array_rand($symbole)],$symbole[array_rand($symbole)]];
    $victoire = ($resultat[0] == "panda" && $resultat[1] == "panda" && $resultat[2] == "panda");
    if(isset($_SESSION["user"]["plats_gratuits"])){
        $nb_plats_gratuits = $_SESSION["user"]["plats_gratuits"];
    }
    else{
        $nb_plats_gratuits = 0;
    }

    if($victoire){
        $nb_plats_gratuits++;
        if(file_exists("JSON/utilisateurs.json")){
            $liste_utilisateurs = lireJson("JSON/utilisateurs.json");
            //En cas de victoire, on cherche l'utilisateur dans le JSON et on rajoute un point gratuit dans le JSON et la session
            foreach($liste_utilisateurs as &$utilisateur){
                if($utilisateur["id"] == $_SESSION["user"]["id"]){
                    $utilisateur["plats_gratuits"] = $nb_plats_gratuits;
                    $_SESSION["user"]["plats_gratuits"] = $nb_plats_gratuits;
                    break;
                }
            }
            ecrireJson("JSON/utilisateurs.json",$liste_utilisateurs);
        }
    }

    //On renvoie les données au fetch

    echo json_encode(["resultat" => $resultat,"victoire" => $victoire, "solde_plat_gratuit" => $nb_plats_gratuits]);

?>