<?php
session_start();
include_once("section/Fonction/fonction.php");
$message = $_SESSION['message_succes_commande'] ?? "Votre commande a bien été enregistrée.";
unset($_SESSION['message_succes_commande']);
$api_key = getAPIKey('MI-4_A');
	$commande    = $_SESSION['commande_en_cours'] ?? null;
	$transaction = $commande['id'] ?? genererTransaction(); // ← id de la commande
	$montant     = $_SESSION['montant_commande'] ?? '0.00';
	$vendeur     = 'MI-4_A';
	$retour      = 'http://localhost/Yumland-Mi4av2/PROJET2/retour_paiement.php?session=s';
	$api_key     = getAPIKey('MI-4_A');
$control     = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>KUNG FOOD - Confirmation</title>
    <link rel="stylesheet" href="CSS/styleMenu.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="stylesheet" href="CSS/Panier.css">
    <link rel="stylesheet" href="CSS/ConfirmationCommande.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
</head>
<body>
    <?php include 'section/Navigation.php'; ?>

    <div class="effetNoir">
        <section class="pageConfirmation">
            <div class="carteConfirmation">
                <h1>Commande confirmée</h1>
                <p><?php echo htmlspecialchars($message); ?></p>
                <div class="payer">
    			<form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
        			<input type="hidden" name="transaction" value="<?= $transaction ?>">
        			<input type="hidden" name="montant" value="<?= $montant ?>">
        			<input type="hidden" name="vendeur" value="<?= $vendeur ?>">
        			<input type="hidden" name="retour" value="<?= $retour ?>">
        			<input type="hidden" name="control" value="<?= $control ?>">
        			<button type="submit">Veuillez payer</button>
                    </form>
            </div>


        </section>
    </div>
</body>
</html>