<?php
session_start();
include_once("section/Fonction/fonction.php");

$estClient = isset($_SESSION['user']) && (($_SESSION['user']['role'] ?? '') === 'client');

$cheminCommandes = "section/JSON/commandes.json";
$commandes = lireJson($cheminCommandes);
$commandeId = trim($_GET['commande_id'] ?? $_POST['commande_id'] ?? '');
$commandeSelectionnee = null;
$messageErreur = '';
$messageSucces = '';
$commandesEligibles = [];

if ($estClient) {
    foreach ($commandes as $commande) {
        $estAuClient = isset($commande['client_id']) && ((string)$commande['client_id'] === (string)($_SESSION['user']['id'] ?? ''));
        $estLivree = (($commande['statut'] ?? '') === 'livrée');

        if ($estAuClient && $estLivree) {
            $commandesEligibles[] = $commande;

            if ($commandeId !== '' && ($commande['id'] ?? '') === $commandeId) {
                $commandeSelectionnee = $commande;
            }
        }
    }

    if ($commandeId !== '' && $commandeSelectionnee === null) {
        $messageErreur = "Cette commande est introuvable, ne vous appartient pas, ou n'a pas encore été livrée.";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer_note'])) {
        $service = (int)($_POST['service'] ?? 0);
        $qualite = (int)($_POST['qualite'] ?? 0);
        $ambiance = (int)($_POST['ambiance'] ?? 0);
        $commentaire = trim($_POST['commentaire'] ?? '');

        if ($commandeSelectionnee === null) {
            $messageErreur = "Commande invalide.";
        } elseif (!empty($commandeSelectionnee['note_commande'])) {
            $messageErreur = "Cette commande a déjà été notée.";
        } elseif ($service < 1 || $service > 5 || $qualite < 1 || $qualite > 5 || $ambiance < 1 || $ambiance > 5) {
            $messageErreur = "Merci de sélectionner une note entre 1 et 5 pour chaque critère.";
        } else {
            foreach ($commandes as &$commande) {
                if (
                    ($commande['id'] ?? '') === $commandeId &&
                    ((string)($commande['client_id'] ?? '') === (string)($_SESSION['user']['id'] ?? ''))
                ) {
                    $commande['note_commande'] = [
                        'service' => $service,
                        'qualite' => $qualite,
                        'ambiance' => $ambiance,
                        'commentaire' => $commentaire,
                        'date_note' => date('Y-m-d H:i:s')
                    ];
                    break;
                }
            }
            unset($commande);

            if (ecrireJson($cheminCommandes, $commandes) === false) {
                $messageErreur = "Impossible d'enregistrer la note pour le moment.";
            } else {
                $messageSucces = "Merci, votre note a bien été enregistrée.";

                foreach ($commandes as $commande) {
                    if (($commande['id'] ?? '') === $commandeId) {
                        $commandeSelectionnee = $commande;
                        break;
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notez votre commande</title>
    <link rel="stylesheet" href="CSS/styleNotation.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
    <script src="section/Javascript/theme.js" defer></script>
</head>
<script src="section/Javascript/check_bloque.js" defer></script>
<body>
<?php include 'section/Navigation.php'; ?>
<div class="Teinte"></div>

<section>
    <div class="logoInscription">
        <img src="image/pandaLogo.png" alt="Logo restaurant panda" />
        <h2>KUNG FOOD</h2>
    </div>

    <div class="Formulaire">
        <fieldset>

            <?php if (!$estClient): ?>
                <h1>Notez-nous</h1>
                <p>Cette page est réservée aux clients connectés.</p>
                <p>Connectez-vous avec un compte client pour noter une commande livrée.</p>

            <?php else: ?>
                <h1>Noter une commande livrée</h1>

                <?php if ($messageErreur !== ''): ?>
                    <p style="color:#b00020; font-weight:bold;"><?php echo htmlspecialchars($messageErreur); ?></p>
                <?php endif; ?>

                <?php if ($messageSucces !== ''): ?>
                    <p style="color:green; font-weight:bold;"><?php echo htmlspecialchars($messageSucces); ?></p>
                    <p><a href="Historique.php">Retour à mon historique</a></p>
                <?php endif; ?>

                <?php if ($commandeSelectionnee !== null): ?>
                    <p><strong>Commande :</strong> <?php echo htmlspecialchars($commandeSelectionnee['id'] ?? ''); ?></p>
                    <p><strong>Total :</strong> <?php echo number_format((float)($commandeSelectionnee['total'] ?? 0), 2, ',', ''); ?> €</p>

                    <?php if (!empty($commandeSelectionnee['note_commande'])): ?>
                        <p>Cette commande a déjà été notée.</p>
                        <p>
                            Service : <?php echo (int)($commandeSelectionnee['note_commande']['service'] ?? 0); ?>/5 |
                            Qualité : <?php echo (int)($commandeSelectionnee['note_commande']['qualite'] ?? 0); ?>/5 |
                            Ambiance : <?php echo (int)($commandeSelectionnee['note_commande']['ambiance'] ?? 0); ?>/5
                        </p>

                        <?php if (!empty($commandeSelectionnee['note_commande']['commentaire'])): ?>
                            <p><strong>Commentaire :</strong> <?php echo nl2br(htmlspecialchars($commandeSelectionnee['note_commande']['commentaire'])); ?></p>
                        <?php endif; ?>

                        <p><a href="Historique.php">Retour à mon historique</a></p>

                    <?php elseif ($messageSucces === ''): ?>
                        <form method="post">
                            <input type="hidden" name="commande_id" value="<?php echo htmlspecialchars($commandeSelectionnee['id'] ?? ''); ?>">

                            <div class="ligne-note">
                                <p>Service :</p>
                                <div class="notation">
                                    <input type="radio" id="service5" name="service" value="5" required><label for="service5">★</label>
                                    <input type="radio" id="service4" name="service" value="4"><label for="service4">★</label>
                                    <input type="radio" id="service3" name="service" value="3"><label for="service3">★</label>
                                    <input type="radio" id="service2" name="service" value="2"><label for="service2">★</label>
                                    <input type="radio" id="service1" name="service" value="1"><label for="service1">★</label>
                                </div>
                            </div>

                            <div class="ligne-note">
                                <p>Qualité des plats :</p>
                                <div class="notation">
                                    <input type="radio" id="qualite5" name="qualite" value="5" required><label for="qualite5">★</label>
                                    <input type="radio" id="qualite4" name="qualite" value="4"><label for="qualite4">★</label>
                                    <input type="radio" id="qualite3" name="qualite" value="3"><label for="qualite3">★</label>
                                    <input type="radio" id="qualite2" name="qualite" value="2"><label for="qualite2">★</label>
                                    <input type="radio" id="qualite1" name="qualite" value="1"><label for="qualite1">★</label>
                                </div>
                            </div>

                            <div class="ligne-note">
                                <p>Ambiance :</p>
                                <div class="notation">
                                    <input type="radio" id="ambiance5" name="ambiance" value="5" required><label for="ambiance5">★</label>
                                    <input type="radio" id="ambiance4" name="ambiance" value="4"><label for="ambiance4">★</label>
                                    <input type="radio" id="ambiance3" name="ambiance" value="3"><label for="ambiance3">★</label>
                                    <input type="radio" id="ambiance2" name="ambiance" value="2"><label for="ambiance2">★</label>
                                    <input type="radio" id="ambiance1" name="ambiance" value="1"><label for="ambiance1">★</label>
                                </div>
                            </div>

                            <div class="commentaire">
                                <label for="commentaire">Commentaire :</label><br>
                                <textarea id="commentaire" name="commentaire" rows="5" cols="40"></textarea>
                            </div>

                            <br>
                            <input type="submit" name="envoyer_note" value="Envoyer la note">
                        </form>
                    <?php endif; ?>

                <?php else: ?>
                    <p>Choisissez une commande livrée à noter :</p>

                    <?php if (empty($commandesEligibles)): ?>
                        <p>Vous n'avez pas encore de commande livrée à noter.</p>
                    <?php else: ?>
                        <?php foreach ($commandesEligibles as $commande): ?>
                            <div style="margin-bottom:12px;">
                                <strong><?php echo htmlspecialchars($commande['id'] ?? ''); ?></strong>
                                – <?php echo !empty($commande['date_creation']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($commande['date_creation']))) : 'Date inconnue'; ?>
                                – <?php echo number_format((float)($commande['total'] ?? 0), 2, ',', ''); ?> €
                                <?php if (!empty($commande['note_commande'])): ?>
                                    <span style="color:green;">(déjà notée)</span>
                                <?php else: ?>
                                    <a href="Note.php?commande_id=<?php echo urlencode($commande['id']); ?>">Noter cette commande</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

        </fieldset>
    </div>
</section>
</body>
</html>