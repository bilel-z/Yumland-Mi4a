<?php include_once("section/traitement_panier.php"); ?>
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
</body>
</html>