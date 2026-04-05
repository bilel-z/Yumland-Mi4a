<?php 
session_start();
include_once("section/Fonction/fonction.php");

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'] ?? '', ['restaurateur', 'administrateur'], true)) {
    header('Location: Connexion.php');
    exit();
}

$cheminCommandes = "section/JSON/commandes.json";
$cheminUtilisateurs = "section/JSON/utilisateurs.json";
$messageSucces = '';
$messageErreur = '';

$statutsDisponibles = ['à préparer', 'en cours', 'à attendre', 'en livraison', 'livrée'];

$utilisateurs = lireJson($cheminUtilisateurs);
$livreursDisponibles = array_values(array_filter($utilisateurs, function ($user) {
    if (($user['role'] ?? '') !== 'livreur') {
        return false;
    }

    if (($user['bloquer'] ?? false) === true) {
        return false;
    }

    if (isset($user['disponible_livraison'])) {
        return (bool) $user['disponible_livraison'];
    }

    return true;
}));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mettre_a_jour_commande'])) {
    $commandeId = trim($_POST['commande_id'] ?? '');
    $nouveauStatut = trim($_POST['statut'] ?? '');
    $livreurId = trim($_POST['livreur_id'] ?? '');

    if ($commandeId === '') {
        $messageErreur = "Commande introuvable.";
    } elseif (!in_array($nouveauStatut, $statutsDisponibles, true)) {
        $messageErreur = "Le statut sélectionné est invalide.";
    } else {
        $commandesBrutes = lireJson($cheminCommandes);
        $commandeTrouvee = false;
        $livreurSelectionne = null;

        if ($livreurId !== '') {
            foreach ($livreursDisponibles as $livreur) {
                if ((string)($livreur['id'] ?? '') === $livreurId) {
                    $livreurSelectionne = $livreur;
                    break;
                }
            }

            if ($livreurSelectionne === null) {
                $messageErreur = "Le livreur sélectionné n'est pas disponible.";
            }
        }

        if ($messageErreur === '') {
            foreach ($commandesBrutes as &$commande) {
                if (($commande['id'] ?? '') === $commandeId) {
                    $commande['statut'] = $nouveauStatut;
                    $commande['date_mise_a_jour'] = date('Y-m-d H:i:s');

                    if ($livreurSelectionne !== null) {
                        $commande['livreur_id'] = $livreurSelectionne['id'];
                        $prenom = $livreurSelectionne['Prenom'] ?? $livreurSelectionne['prenom'] ?? '';
                        $nom = $livreurSelectionne['Nom'] ?? $livreurSelectionne['nom'] ?? '';
                        $commande['livreur_nom'] = trim($prenom . ' ' . $nom);
                    } elseif ($livreurId === '') {
                        $commande['livreur_id'] = null;
                        $commande['livreur_nom'] = '';
                    }

                    $commandeTrouvee = true;
                    break;
                }
            }
            unset($commande);

            if (!$commandeTrouvee) {
                $messageErreur = "Impossible de retrouver cette commande.";
            } elseif (ecrireJson($cheminCommandes, array_values($commandesBrutes)) === false) {
                $messageErreur = "La commande n'a pas pu être mise à jour.";
            } else {
                $messageSucces = "La commande {$commandeId} a bien été mise à jour.";
            }
        }
    }
}

$commandes = array_reverse(lireJson($cheminCommandes));
$filtre = isset($_GET["statut"]) ? $_GET["statut"] : "Tous";

if ($filtre !== "Tous") {
    $commandes = array_filter($commandes, function($commande) use ($filtre) {
        return isset($commande["statut"]) && $commande["statut"] === $filtre;
    });
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des commandes</title>
    <link rel="stylesheet" href="CSS/styleAdmin+commandes.css?v=2">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
<body>

    <?php include 'section/Navigation.php'; ?>

    <div class="effetNoir">
        <main class="contenu">
            <section class="hero-commandes">
                <h1>Gestion des commandes</h1>
                <p class="intro-page">
                    Voici les commandes actuelles
                </p>
            </section>

            <?php if($messageSucces !== ''): ?>
                <div class="message-flash succes"><?php echo htmlspecialchars($messageSucces); ?></div>
            <?php endif; ?>

            <?php if($messageErreur !== ''): ?>
                <div class="message-flash erreur"><?php echo htmlspecialchars($messageErreur); ?></div>
            <?php endif; ?>

            <section class="bloc-commandes">
                <div class="filtres">
                    <a href="commandes.php?statut=Tous" class="filtres-bouton <?php echo ($filtre === 'Tous') ? 'actif' : ''; ?>">Tous</a>
                    <a href="commandes.php?statut=à préparer" class="filtres-bouton <?php echo ($filtre === 'à préparer') ? 'actif' : ''; ?>">à préparer</a>
                    <a href="commandes.php?statut=en cours" class="filtres-bouton <?php echo ($filtre === 'en cours') ? 'actif' : ''; ?>">en cours</a>
                    <a href="commandes.php?statut=à attendre" class="filtres-bouton <?php echo ($filtre === 'à attendre') ? 'actif' : ''; ?>">à attendre</a>
                    <a href="commandes.php?statut=en livraison" class="filtres-bouton <?php echo ($filtre === 'en livraison') ? 'actif' : ''; ?>">en livraison</a>
                    <a href="commandes.php?statut=livrée" class="filtres-bouton <?php echo ($filtre === 'livrée') ? 'actif' : ''; ?>">livrée</a>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Commande</th>
                                <th>Nb articles</th>
                                <th>Statut</th>
                                <th>Détail / action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($commandes)): ?>
                                <tr>
                                    <td colspan="5">Aucune commande enregistrée pour le moment.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($commandes as $commande): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($commande['client_nom'] ?? 'Client inconnu'); ?></strong>
                                            <br><span class="commande-id"><?php echo htmlspecialchars($commande['id'] ?? ''); ?></span>
                                        </td>

                                        <td>
                                            <?php 
                                            if (isset($commande['articles']) && is_array($commande['articles']) && !empty($commande['articles'])) {
                                                echo htmlspecialchars(implode(', ', array_column($commande['articles'], 'nom')));
                                            } else {
                                                echo "Aucun article";
                                            }
                                            ?>
                                        </td>

                                        <td><?php echo (int)($commande['nombre_articles'] ?? 0); ?></td>

                                        <td>
                                            <span class="badge-statut"><?php echo htmlspecialchars($commande['statut'] ?? 'inconnu'); ?></span>
                                            <?php if(!empty($commande['livreur_nom'])): ?>
                                                <br><span class="texte-secondaire">Livreur : <?php echo htmlspecialchars($commande['livreur_nom']); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="colonne-detail">
                                            <details>
                                                <summary>Voir le détail</summary>

                                                <div class="bloc-detail">
                                                    <div class="detail-grid">
                                                        <div>
                                                            <p><strong>Créée le :</strong> <?php echo !empty($commande['date_creation']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($commande['date_creation']))) : '—'; ?></p>
                                                            <p><strong>Type :</strong> <?php echo htmlspecialchars($commande['type_service'] ?? 'Non renseigné'); ?></p>
                                                            <p><strong>Total :</strong> <?php echo number_format((float)($commande['total'] ?? 0), 2, ',', ''); ?> €</p>
                                                            <p><strong>Paiement :</strong> <?php echo htmlspecialchars($commande['paiement_statut'] ?? 'inconnu'); ?></p>
                                                        </div>

                                                        <div>
                                                            <p>
                                                                <strong>Préparation :</strong>
                                                                <?php if(($commande['moment_preparation'] ?? '') === 'plus_tard' && !empty($commande['date_retrait_livraison'])): ?>
                                                                    Prévu le <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($commande['date_retrait_livraison']))); ?>
                                                                <?php else: ?>
                                                                    Immédiate
                                                                <?php endif; ?>
                                                            </p>
                                                            <p><strong>Adresse :</strong> <?php echo !empty($commande['adresse_livraison']) ? nl2br(htmlspecialchars($commande['adresse_livraison'])) : 'Aucune adresse'; ?></p>
                                                            <p><strong>Commentaire :</strong> <?php echo !empty($commande['commentaire']) ? nl2br(htmlspecialchars($commande['commentaire'])) : 'Aucun commentaire'; ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="liste-articles">
                                                        <strong>Articles commandés :</strong>
                                                        <ul>
                                                            <?php if (!empty($commande['articles']) && is_array($commande['articles'])): ?>
                                                                <?php foreach($commande['articles'] as $article): ?>
                                                                    <li>
                                                                        <?php echo htmlspecialchars($article['nom'] ?? 'Article'); ?>
                                                                        — Qté : <?php echo (int)($article['quantite'] ?? 0); ?>
                                                                        — <?php echo number_format((float)($article['sous_total'] ?? 0), 2, ',', ''); ?> €
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <li>Aucun article</li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>

                                                    <form method="POST" class="form-action-commande">
                                                        <input type="hidden" name="commande_id" value="<?php echo htmlspecialchars($commande['id'] ?? ''); ?>">

                                                        <label>
                                                            Statut
                                                            <select name="statut" required>
                                                                <?php foreach($statutsDisponibles as $statut): ?>
                                                                    <option value="<?php echo htmlspecialchars($statut); ?>" <?php echo (($commande['statut'] ?? '') === $statut) ? 'selected' : ''; ?>>
                                                                        <?php echo htmlspecialchars($statut); ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </label>

                                                        <label>
                                                            Livreur disponible
                                                            <select name="livreur_id">
                                                                <option value="">Non attribuée</option>
                                                                <?php foreach($livreursDisponibles as $livreur): ?>
                                                                    <?php $nomLivreur = trim(($livreur['Prenom'] ?? '') . ' ' . ($livreur['Nom'] ?? '')); ?>
                                                                    <option value="<?php echo htmlspecialchars((string)$livreur['id']); ?>" <?php echo ((string)($commande['livreur_id'] ?? '') === (string)($livreur['id'] ?? '')) ? 'selected' : ''; ?>>
                                                                        <?php echo htmlspecialchars($nomLivreur !== '' ? $nomLivreur : ('Livreur #' . ($livreur['id'] ?? ''))); ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </label>

                                                        <?php if (empty($livreursDisponibles)): ?>
                                                            <p class="info-phase">Aucun livreur disponible pour le moment.</p>
                                                        <?php else: ?>
                                                            <p class="info-phase">Sélectionnez un livreur et un statut puis cliquez sur Enregistrer.</p>
                                                        <?php endif; ?>

                                                        <button type="submit" name="mettre_a_jour_commande" class="Envoi">Enregistrer</button>
                                                    </form>
                                                </div>
                                            </details>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>