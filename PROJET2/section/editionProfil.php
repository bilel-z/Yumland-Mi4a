<?php

    include_once(__DIR__ . "/Fonction/fonction.php");
    securiserCookieSession();
    session_start();
    if (!requeteInterne()) { http_response_code(403); echo json_encode(["succes" => false, "message" => "Requête refusée."]); exit(); }
    $requete = json_decode(file_get_contents("php://input"),true);
    if($requete === null || !isset($requete["Prenom"]) || !isset($requete["Nom"]) || !isset($requete["Mail"]) || !isset($requete["Num"]) || !isset($requete["Adresse"]) || !isset($requete["Interphone"]) || !isset($requete["Age"])) {
        echo json_encode(["succes" => false, "message" => "Erreur avec les données", "code" => "DonneeCorrompu"]);
        exit();
    }

    // On charge la liste des utilisateurs depuis le JSON et on vérifie que l'utilisateur est bien connecté
    $utilisateurs = lireJson(__DIR__ . "/JSON/utilisateurs.json");
    if (!isset($_SESSION["user"])) {
        echo json_encode(["succes" => false, "message" => "L'utilisateur n'est pas connecté", "code" => "NonConnection"]);
        exit();
    }
    
    $id_actuel = $_SESSION["user"]["id"];

    //On nettoie toutes les entrées
    $requete["Prenom"]     = nettoyerEntree($requete["Prenom"], 50);
    $requete["Nom"]        = nettoyerEntree($requete["Nom"], 50);
    $requete["Mail"]       = nettoyerEntree($requete["Mail"], 100);
    $requete["Num"]        = nettoyerEntree($requete["Num"], 20);
    $requete["Adresse"]    = nettoyerEntree($requete["Adresse"], 200);
    $requete["Interphone"] = nettoyerEntree($requete["Interphone"], 50);
    $requete["Age"]        = nettoyerEntree($requete["Age"], 20);

    //On vérifie si l'utilisateur souhaite changer son mot de passe
    $VerifChangementMDP = false;
    if (isset($requete["NouveauMDP"]) && trim($requete["NouveauMDP"]) != ""){
        //On vérifie que l'ancien mot de passe a bien été fourni
        if (empty($requete["AncienMDP"])){
            echo json_encode(["succes" => false, "code" => "ErreurMDP", "message" => "Entrez l'ancien mot de passe"]);
            exit();
        }
        //On vérifie que l'ancien mot de passe correspond bien à celui en base
        if (!password_verify($requete["AncienMDP"], $_SESSION["user"]["Mdp"])){
            echo json_encode(["succes" => false, "code" => "ErreurMDP", "message" => "Mot de passe incorrect"]);
            exit();
        }
        
        $VerifChangementMDP = true;
        $nouveauMDP = password_hash($requete["NouveauMDP"], PASSWORD_DEFAULT);
    }
    if ($VerifChangementMDP){
        $_SESSION["user"]["Mdp"] = $nouveauMDP;
    }

    foreach($utilisateurs as $user){
        if($user["id"] != $id_actuel && $user["Mail"] == $requete["Mail"]){
            echo json_encode(["succes" => false, "message" => "Cette adresse mail est déjà utilisée par un autre compte", "code" => "MailDoublon"]);
            exit();
        }
    }

    //On met à jour les données de l'utilisateur dans la session
    $_SESSION["user"]["Prenom"] = $requete["Prenom"];
    $_SESSION["user"]["Nom"] = $requete["Nom"];
    $_SESSION["user"]["Mail"] = $requete["Mail"];
    $_SESSION["user"]["numero"] = $requete["Num"];
    $_SESSION["user"]["adresse"] = $requete["Adresse"];
    $_SESSION["user"]["interphone"] = $requete["Interphone"];
    $_SESSION["user"]["age"] = $requete["Age"];
    
    // On stocke les nouvelles données de l'utilisateur dans le fichier JSON
    foreach($utilisateurs as &$user){
        if($user["id"] == $id_actuel){
            $user["Prenom"] = $requete["Prenom"];
            $user["Nom"] = $requete["Nom"];
            $user["Mail"] = $requete["Mail"];
            $user["numero"] = $requete["Num"];
            $user["adresse"] = $requete["Adresse"];
            $user["interphone"] = $requete["Interphone"];
            $user["age"] = $requete["Age"];
            if ($VerifChangementMDP) {
                $user["Mdp"] = $nouveauMDP;
            }
            break;
        }
    }
    unset($user);
    ecrireJson(__DIR__ . "/JSON/utilisateurs.json",$utilisateurs);
    echo json_encode(["succes" => true]);
?>