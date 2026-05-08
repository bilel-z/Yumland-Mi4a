<?php

    session_start();
    include_once(__DIR__ . "/Fonction/fonction.php");
    $requete = json_decode(file_get_contents("php://input"),true);
    if($requete === null || !isset($requete["Prenom"]) || !isset($requete["Nom"]) || !isset($requete["Mail"]) || !isset($requete["Num"]) || !isset($requete["Adresse"]) || !isset($requete["Interphone"]) || !isset($requete["Age"])) {
        echo json_encode(["succes" => false, "message" => "Erreur avec les données"]);
        exit();
    }
    $utilisateurs = lireJson(__DIR__ . "/JSON/utilisateurs.json");
    if (!isset($_SESSION["user"])) {
        echo json_encode(["succes" => false, "message" => "L'utilisateur n'est pas connecté"]);
        exit();
    }
    
    $id_actuel = $_SESSION["user"]["id"];

    $_SESSION["user"]["Prenom"] = $requete["Prenom"];
    $_SESSION["user"]["Nom"] = $requete["Nom"];
    $_SESSION["user"]["Mail"] = $requete["Mail"];
    $_SESSION["user"]["numero"] = $requete["Num"];
    $_SESSION["user"]["adresse"] = $requete["Adresse"];
    $_SESSION["user"]["interphone"] = $requete["Interphone"];
    $_SESSION["user"]["age"] = $requete["Age"];
    
    foreach($utilisateurs as &$user){
        if($user["id"] == $id_actuel){
            $user["Prenom"] = $requete["Prenom"];
            $user["Nom"] = $requete["Nom"];
            $user["Mail"] = $requete["Mail"];
            $user["numero"] = $requete["Num"];
            $user["adresse"] = $requete["Adresse"];
            $user["interphone"] = $requete["Interphone"];
            $user["age"] = $requete["Age"];
            break;
        }
    }
    unset($user);
    ecrireJson(__DIR__ . "/JSON/utilisateurs.json",$utilisateurs);
    echo json_encode(["succes" => true]);
?>