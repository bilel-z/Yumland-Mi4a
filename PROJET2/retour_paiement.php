<?php
session_start();
include_once("section/Fonction/fonction.php");

$transaction     = $_GET["transaction"] ?? '';
$montant         = $_GET["montant"] ?? '';
$vendeur         = $_GET["vendeur"] ?? '';
$statut          = $_GET["status"] ?? '';
$control         = $_GET["control"] ?? '';

// Vérification du control
$api_key         = getAPIKey($vendeur);
$control_calcule = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $statut . "#");

if ($control !== $control_calcule) {
    die("Erreur : données invalides.");
}

// Mise à jour du paiement_statut dans le JSON
if ($statut === "accepted") {
    $cheminCommandes = __DIR__ . '/section/JSON/commandes.json';
    $commandes = lireJson($cheminCommandes);

    foreach ($commandes as &$commande) {
        if ($commande['id'] === $transaction) {
            $commande['paiement_statut'] = 'complété'; // ← mise à jour
            break;
        }
    }

    ecrireJson($cheminCommandes, $commandes);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Retour paiement</title>
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="stylesheet" href="CSS/Panier.css">
</head>
<body>
    <?php if ($statut === "accepted"): ?>
        <h1>✅ Paiement accepté !</h1>
        <p>Montant payé : <?= htmlspecialchars($montant) ?> €</p>
        <p>Transaction : <?= htmlspecialchars($transaction) ?></p>
    <?php else: ?>
        <h1>❌ Paiement refusé.</h1>
        <p>Votre commande reste enregistrée mais le paiement n'a pas abouti.</p>
    <?php endif; ?>
    <a href="Acceuil.php">Retour à l'accueil</a>
</body>
</html>