<?php
session_start();
include_once(__DIR__ . "/Fonction/fonction.php");

header('Content-Type: application/json');

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "client") {
    echo json_encode(["succes" => false, "erreur" => "Non autorisé."]);
    exit();
}

$body = json_decode(file_get_contents("php://input"), true);
$commandeId  = trim($body["commande_id"] ?? "");
$articles = $body["articles"] ?? [];
$nouveauTotal = round((float)($body["nouveau_total"] ?? 0), 2);

if ($commandeId === "" || empty($articles)) {
    echo json_encode(["succes" => false, "erreur" => "Données invalides."]);
    exit();
}

$cheminCommandes = __DIR__ . "/JSON/commandes.json";
$commandes = lireJson($cheminCommandes);
$commandeIndex = null;
$commande = null;

foreach ($commandes as $i => $c) {
    if (($c["id"] ?? "") === $commandeId && (string)($c["client_id"] ?? "") === (string)$_SESSION["user"]["id"]) {
        $commandeIndex = $i;
        $commande = $c;
        break;
    }
}

if ($commande === null) {
    echo json_encode(["succes" => false, "erreur" => "Commande introuvable."]);
    exit();
}

$statutsModifiables = ["à préparer", "à attendre"];
if (!in_array($commande["statut"] ?? "", $statutsModifiables, true) || ($commande["paiement_statut"] ?? "") !== "complété") {
    echo json_encode(["succes" => false, "erreur" => "Cette commande ne peut plus être modifiée."]);
    exit();
}

$ancienTotal = round((float)($commande["total"] ?? 0), 2);
$diff = round($nouveauTotal - $ancienTotal, 2);

$commandes[$commandeIndex]["articles"] = $articles;
$commandes[$commandeIndex]["total"] = $nouveauTotal;
$commandes[$commandeIndex]["nombre_articles"] = array_sum(array_column($articles, "quantite"));

ecrireJson($cheminCommandes, $commandes);

if ($diff > 0) {
    $transaction = genererTransaction();
    $montant     = number_format($diff, 2, '.', '');
    $vendeur     = 'MI-4_A';
    $retour      = 'http://localhost:8888/Yumland-Mi4a-1/PROJET2/retour_paiement.php?session=s&complement=1&commande_id=' . urlencode($commandeId);
    $api_key     = getAPIKey($vendeur);
    $control     = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");

    echo json_encode([
        "succes" => true,
        "paiement_requis" => true,
        "cybank" => [
            "transaction" => $transaction,
            "montant" => $montant,
            "vendeur" => $vendeur,
            "retour"  => $retour,
            "control" => $control
        ]
    ]);
} else {
    echo json_encode(["succes" => true, "paiement_requis" => false]);
}
?>