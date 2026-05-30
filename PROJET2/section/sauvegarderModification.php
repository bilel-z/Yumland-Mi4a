<?php
include_once(__DIR__ . "/Fonction/fonction.php");
securiserCookieSession();
session_start();

header('Content-Type: application/json');

if (!requeteInterne()) {
    echo json_encode(["succes" => false, "erreur" => "Requête refusée."]);
    exit();
}

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

$prixPlats = [];
foreach (lireJson(__DIR__ . "/JSON/plats.json") as $plat) {
    if (isset($plat["nom"])) {
        $prixPlats[$plat["nom"]] = (float)($plat["prix"] ?? 0);
    }
}
$prixOrigine = [];
foreach (($commande["articles"] ?? []) as $art) {
    if (isset($art["nom"])) {
        $prixOrigine[$art["nom"]] = (float)($art["prix_unitaire"] ?? 0);
    }
}

$articlesValides = [];
$totalRecalcule = 0;
foreach ($articles as $art) {
    $nom = (string)($art["nom"] ?? "");
    $quantite = (int)($art["quantite"] ?? 0);
    if ($nom === "" || $quantite <= 0) {
        continue;
    }
    if (isset($prixPlats[$nom])) {
        $prixReel = $prixPlats[$nom];
    } elseif (isset($prixOrigine[$nom])) {
        $prixReel = $prixOrigine[$nom];
    } else {
        echo json_encode(["succes" => false, "erreur" => "Article invalide dans la commande."]);
        exit();
    }
    $sousTotal = round($prixReel * $quantite, 2);
    $articlesValides[] = [
        "nom" => $nom,
        "prix_unitaire" => $prixReel,
        "quantite" => $quantite,
        "sous_total" => $sousTotal
    ];
    $totalRecalcule += $sousTotal;
}
$totalRecalcule = round($totalRecalcule, 2);

if (empty($articlesValides)) {
    echo json_encode(["succes" => false, "erreur" => "Données invalides."]);
    exit();
}

$diff = round($totalRecalcule - $ancienTotal, 2);

$commandes[$commandeIndex]["articles"] = $articlesValides;
$commandes[$commandeIndex]["total"] = $totalRecalcule;
$commandes[$commandeIndex]["nombre_articles"] = array_sum(array_column($articlesValides, "quantite"));

ecrireJson($cheminCommandes, $commandes);

if ($diff > 0) {
    $transaction = genererTransaction();
    $montant     = number_format($diff, 2, '.', '');
    $vendeur     = 'MI-4_A';
    $retour      = 'http://localhost:8000/retour_paiement.php?session=s&complement=1&commande_id=' . urlencode($commandeId);
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