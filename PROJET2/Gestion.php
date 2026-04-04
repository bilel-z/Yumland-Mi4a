<?php 
session_start();
include_once("section/Fonction/fonction.php");

if (!isset($_SESSION['user']) || (($_SESSION['user']['role'] ?? '') !== 'restaurateur')) {
    header('Location: Connexion.php');
    exit();
}

$commandes = lireJson("section/JSON/commandes.json");
$plats = lireJson("section/JSON/plats.json");
$utilisateurs = lireJson("section/JSON/utilisateurs.json");

$nbCommandes = count($commandes);
$nbCommandesActives = 0;
$chiffreAffaires = 0;
$nbPlats = count($plats);
$nbLivreursDisponibles = 0;

foreach ($commandes as $commande) {
    $statut = $commande['statut'] ?? '';
    if (!in_array($statut, ['livrée', 'annulée'], true)) {
        $nbCommandesActives++;
    }
    if ($statut === 'livrée') {
        $chiffreAffaires += (float)($commande['total'] ?? 0);
    }
}

foreach ($utilisateurs as $utilisateur) {
    if (($utilisateur['role'] ?? '') === 'livreur' && (($utilisateur['bloquer'] ?? false) === false)) {
        if (!isset($utilisateur['disponible_livraison']) || $utilisateur['disponible_livraison']) {
            $nbLivreursDisponibles++;
        }
    }
}

$dernieresCommandes = array_reverse($commandes);
$dernieresCommandes = array_slice($dernieresCommandes, 0, 5);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUNG FOOD - Gestion</title>
    <link rel="stylesheet" href="CSS/styleGestion.css">
    <link rel="stylesheet" href="CSS/BarreNav.css">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
<body>
    <?php include 'section/Navigation.php'; ?>

    <div class="overlay-page">
        <main class="contenu-gestion">
            <section class="hero-gestion">
                <p class="sur-titre">Espace restaurateur</p>
                <h1>Gestion du restaurant</h1>
            </section>

            <section class="grille-stats">
                <article class="carte-stat">
                    <span class="libelle">Commandes totales</span>
                    <strong><?php echo (int)$nbCommandes; ?></strong>
                </article>
                <article class="carte-stat">
                    <span class="libelle">Commandes actives</span>
                    <strong><?php echo (int)$nbCommandesActives; ?></strong>
                </article>
                <article class="carte-stat">
                    <span class="libelle">Plats au menu</span>
                    <strong><?php echo (int)$nbPlats; ?></strong>
                </article>
                <article class="carte-stat">
                    <span class="libelle">Livreurs disponibles</span>
                    <strong><?php echo (int)$nbLivreursDisponibles; ?></strong>
                </article>
                <article class="carte-stat large">
                    <span class="libelle">Chiffre d'affaires livré</span>
                    <strong><?php echo number_format($chiffreAffaires, 2, ',', ' '); ?> €</strong>
                </article>
            </section>

            <section class="grille-actions">
                <article class="carte-action">
                    <h2>Suivi des commandes</h2>
                    <p>Consultez les commandes en cours, changez leur statut et assignez un livreur.</p>
                    <a href="commandes.php" class="btn-action">Ouvrir les commandes</a>
                </article>

                <article class="carte-action">
                    <h2>Profil</h2>
                    <p>Accédez rapidement à votre profil restaurateur et à vos informations de compte.</p>
                    <a href="Profil.php" class="btn-action second">Voir mon profil</a>
                </article>
            </section>

            <section class="carte-tableau">
                <div class="entete-tableau">
                    <h2>Dernières commandes</h2>
                    <a href="commandes.php">Tout voir</a>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Client</th>
                                <th>Statut</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($dernieresCommandes)): ?>
                                <tr>
                                    <td colspan="4">Aucune commande enregistrée pour le moment.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($dernieresCommandes as $commande): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($commande['id'] ?? '—'); ?></td>
                                        <td><?php echo htmlspecialchars($commande['client_nom'] ?? 'Client inconnu'); ?></td>
                                        <td><?php echo htmlspecialchars($commande['statut'] ?? 'inconnu'); ?></td>
                                        <td><?php echo number_format((float)($commande['total'] ?? 0), 2, ',', ' '); ?> €</td>
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