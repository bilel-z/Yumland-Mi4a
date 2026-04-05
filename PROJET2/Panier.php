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
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>KUNG FOOD - Panier</title>
    <link rel="stylesheet" href="CSS/styleMenu.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="stylesheet" href="CSS/Panier.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
<body>
    <?php include 'section/Navigation.php'; ?>

    <div class="effetNoir">

        <?php if($messageErreur !== ""): ?>
            <div class="messagePanier messageErreur"><?php echo htmlspecialchars($messageErreur); ?></div>
        <?php endif; ?>

        <?php if($messageSucces !== ""): ?>
            <div class="messagePanier messageSucces"><?php echo htmlspecialchars($messageSucces); ?></div>
        <?php endif; ?>

        <section class="panierCommande">

            <div class="colonneGauchePanier">
                <section class="TitrePanier">
                    <div class="Titre">
                        <h1>Panier</h1>
                    </div>
                    <div class="nbPlat">
                        <?php echo count($_SESSION["Panier"]).' Articles'; ?>
                    </div>
                </section>

                <div class="panierPlat">
                    <?php include('section/elementPanier.php'); ?>
                </div>
            </div>

            <div class="colonneDroitePanier">
                <div class="panierPayer grandeCarte">
                    <div class="espacePaye">
                        <div class="surPayer">
                            <div>Nombre d'articles</div>
                            <div><?php echo count($_SESSION["Panier"]) ?></div>
                        </div>
                        <div class="surPayer">
                            <div><b>Total</b></div>
                            <div class="prixPanier"><?php echo number_format(total($_SESSION["Panier"]),2,',','').' €'; ?></div>
                        </div>
                    </div>

                    <?php if(!empty($_SESSION['Panier'])): ?>
                    <form method="post" class="formCommande" id="formCommande">
                        <div class="champCommande">
                            <label for="type_service">Type de commande</label>
                            <select name="type_service" id="type_service">
                                <option value="emporter">À emporter</option>
                                <option value="livraison">Livraison</option>
                            </select>
                        </div>

                        <div class="champCommande">
                            <label for="moment_preparation">Préparation</label>
                            <select name="moment_preparation" id="moment_preparation">
                                <option value="immediate">Préparation immédiate</option>
                                <option value="plus_tard">Retrait / livraison plus tard</option>
                            </select>
                        </div>

                        <div class="champCommande champCache" id="bloc_date">
                            <label for="date_retrait_livraison">Date et heure prévues</label>
                            <input type="datetime-local" name="date_retrait_livraison" id="date_retrait_livraison">
                        </div>

                        <div class="champCommande champCache" id="bloc_adresse">
                            <label for="adresse_livraison">Adresse de livraison</label>
                            <textarea name="adresse_livraison" id="adresse_livraison" rows="3"><?php echo isset($_SESSION['user']['adresse']) ? htmlspecialchars($_SESSION['user']['adresse']) : ''; ?></textarea>
                        </div>

                        <div class="champCommande">
                            <label for="commentaire_commande">Commentaire</label>
                            <textarea name="commentaire_commande" id="commentaire_commande" rows="3" placeholder="Interphone, précision pour la livraison, heure souhaitée..."></textarea>
                        </div>

                        <div class="resumePlanification" id="resumePlanification">
                            Cette commande sera préparée tout de suite.
                        </div>

                        <div class="payer">
                            <button type="submit" name="valider_commande">Valider la commande</button>
                            <a href="Menu.php">Continuer les achats</a>
                        </div>
                    </form>
                    <?php else: ?>
                    <div class="payer">
                        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
                            <input type="hidden" name="transaction" value="<?= $transaction ?>">
                            <input type="hidden" name="montant" value="<?= $montant ?>">
                            <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
                            <input type="hidden" name="retour" value="<?= $retour ?>">
                            <input type="hidden" name="control" value="<?= $control ?>">
                            <button type="submit">Commander</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </section>
    </div>

    <script>
        const typeService = document.getElementById('type_service');
        const momentPreparation = document.getElementById('moment_preparation');
        const blocDate = document.getElementById('bloc_date');
        const blocAdresse = document.getElementById('bloc_adresse');
        const champDate = document.getElementById('date_retrait_livraison');
        const champAdresse = document.getElementById('adresse_livraison');
        const resume = document.getElementById('resumePlanification');

        function mettreAJourAffichageCommande() {
            if (!typeService || !momentPreparation) {
                return;
            }

            const plusTard = momentPreparation.value === 'plus_tard';
            const livraison = typeService.value === 'livraison';

            blocDate.classList.toggle('champCache', !plusTard);
            blocAdresse.classList.toggle('champCache', !livraison);
            champDate.required = plusTard;
            champAdresse.required = livraison;

            if (plusTard) {
                resume.textContent = livraison
                    ? "Cette commande sera livrée plus tard. Elle ne doit pas être préparée tout de suite."
                    : "Cette commande sera récupérée plus tard. Elle ne doit pas être préparée tout de suite.";
            } else {
                resume.textContent = livraison
                    ? "Cette commande est à livrer dès qu'elle sera prête."
                    : "Cette commande sera préparée immédiatement pour un retrait rapide.";
            }
        }

        if (typeService && momentPreparation) {
            typeService.addEventListener('change', mettreAJourAffichageCommande);
            momentPreparation.addEventListener('change', mettreAJourAffichageCommande);
            mettreAJourAffichageCommande();
        }
    </script>
</body>
</html>