<?php 
session_start();
include_once("section/Fonction/fonction.php");

if (!isset($_SESSION["Panier"])) {
    $_SESSION["Panier"] = [];
}

$messageErreur = "";
$messageSucces = $_SESSION['message_succes_commande'] ?? "";
unset($_SESSION['message_succes_commande']);

if(isset($_POST["Ajouter"]) && $_POST["Ajouter"] == "Supprimer"){
    if(isset($_POST["nomSuppr"])){
        $nom = $_POST["nomSuppr"];
        $prix = null;

        foreach($_SESSION["Panier"] as $plat){
            if(isset($plat[0]) && $plat[0] == $nom){
                $prix = $plat[1];
                break;
            }
        }

        if($prix !== null){
            SupprPanier($_SESSION["Panier"], $nom, $prix);
        }
    }
}
$api_key = getAPIKey('MI-4_A');
$transaction = genererTransaction();
$montant = number_format(total($_SESSION["Panier"]), 2, '.', '');
$vendeur = 'MI-4_A';
$statut = 'OK';
$retour = 'http://localhost/Yumland-Mi4av2/PROJET2/retour_paiement.php?session=s';
$control     = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
	
if(isset($_POST['valider_commande'])){
    if(!isset($_SESSION['user'])){
        $messageErreur = "Vous devez être connecté pour valider une commande.";
    } elseif(empty($_SESSION['Panier'])) {
        $messageErreur = "Votre panier est vide.";
    } else {
        $typeService = $_POST['type_service'] ?? 'emporter';
        $momentPreparation = $_POST['moment_preparation'] ?? 'immediate';
        $dateRetrait = trim($_POST['date_retrait_livraison'] ?? '');
        $adresseLivraison = trim($_POST['adresse_livraison'] ?? '');
        $commentaireCommande = trim($_POST['commentaire_commande'] ?? '');

        if($momentPreparation === 'immediate'){
            $dateRetrait = '';
        }

        if(!in_array($typeService, ['emporter', 'livraison'], true)){
            $messageErreur = "Le type de service choisi est invalide.";
        } elseif(!in_array($momentPreparation, ['immediate', 'plus_tard'], true)){
            $messageErreur = "Le moment de préparation choisi est invalide.";
        } elseif($momentPreparation === 'plus_tard' && $dateRetrait === ''){
            $messageErreur = "Veuillez choisir une date et une heure pour une commande prévue plus tard.";
        } else {
            $dateRetraitFormatee = null;

            if($dateRetrait !== ''){
                $timestamp = strtotime($dateRetrait);

                if($timestamp === false){
                    $messageErreur = "La date choisie est invalide.";
                } elseif($timestamp <= time()) {
                    $messageErreur = "La date prévue doit être dans le futur.";
                } else {
                    $dateRetraitFormatee = date('Y-m-d H:i:s', $timestamp);
                }
            }

            if($messageErreur === '' && $typeService === 'livraison' && $adresseLivraison === ''){
                $messageErreur = "Veuillez renseigner l'adresse de livraison.";
            }

            if($messageErreur === ''){
                $cheminCommandes = __DIR__ . '/section/JSON/commandes.json';
                $commandes = lireJson($cheminCommandes);

                if(!is_array($commandes)){
                    $commandes = [];
                }

                $commande = [
                    'id' => $transaction,
                    'client_id' => $_SESSION['user']['id'],
                    'client_interphone' => $_SESSION['user']['interphone'] ?? '',
                    'client_telephone' => $_SESSION['user']['numero'],
                    'client_nom' => trim($_SESSION['user']['Prenom'] . ' ' . $_SESSION['user']['Nom']),
                    'articles' => convertirPanierEnArticles($_SESSION['Panier']),
                    'nombre_articles' => count($_SESSION['Panier']),
                    'total' => round(total($_SESSION["Panier"]), 2),
                    'type_service' => $typeService,
                    'moment_preparation' => $momentPreparation,
                    'date_retrait_livraison' => $dateRetraitFormatee,
                    'adresse_livraison' => $typeService === 'livraison' ? $adresseLivraison : '',
                    'commentaire' => $commentaireCommande,
                    'statut' => $momentPreparation === 'immediate' ? 'à préparer' : 'à attendre',
                    'paiement_statut' => 'en attente',
                    'date_creation' => date('Y-m-d H:i:s')
                ];

                $commandes[] = $commande;

                if(ecrireJson($cheminCommandes, $commandes) !== false){
                    $_SESSION['message_succes_commande'] = "Commande enregistrée avec succès. " .
                        ($momentPreparation === 'immediate'
                            ? "Elle peut être préparée tout de suite."
                            : "Elle a bien été planifiée pour plus tard.");

                    $_SESSION['Panier'] = [];
                    $_SESSION['commande_en_cours'] = $commande;
                    $_SESSION['montant_commande'] = number_format($commande['total'], 2, '.', '');
                    $_SESSION['Panier'] = [];
                    header("Location: ConfirmationCommande.php");
                    exit();
                } else {
                    $messageErreur = "Erreur lors de l'enregistrement de la commande.";
                }
            }
        }
    }
}
?>