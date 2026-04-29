<?php
session_start();
include_once("section/Fonction/fonction.php");

if (
    !isset($_SESSION['user']) ||
    !isset($_SESSION['user']['role']) ||
    $_SESSION['user']['role'] !== 'restaurateur'
) {
    header('Location: Connexion.php');
    exit();
}

$listeCommandes = lireJson("section/JSON/commandes.json");
$listePlats = lireJson("section/JSON/plats.json");
$listeUtilisateurs = lireJson("section/JSON/utilisateurs.json");

$nombreCommandes = count($listeCommandes);
$nombreCommandesActives = 0;
$chiffreAffaires = 0;
$nombrePlats = count($listePlats);
$nombreLivreursDisponibles = 0;

foreach ($listeCommandes as $commande) {
    $statutCommande = '';

    if (isset($commande['statut'])) {
        $statutCommande = $commande['statut'];
    }

    if ($statutCommande !== 'livrée' && $statutCommande !== 'annulée') {
        $nombreCommandesActives++;
    }

    if ($statutCommande === 'livrée') {
        if (isset($commande['total'])) {
            $chiffreAffaires += (float) $commande['total'];
        }
    }
}

foreach ($listeUtilisateurs as $utilisateur) {
    $estLivreur = false;
    $estBloque = false;
    $estDisponible = true;

    if (isset($utilisateur['role']) && $utilisateur['role'] === 'livreur') {
        $estLivreur = true;
    }

    if (isset($utilisateur['bloquer']) && $utilisateur['bloquer'] === true) {
        $estBloque = true;
    }

    if (isset($utilisateur['disponible_livraison']) && $utilisateur['disponible_livraison'] === false) {
        $estDisponible = false;
    }

    if ($estLivreur && !$estBloque && $estDisponible) {
        $nombreLivreursDisponibles++;
    }
}

$dernieresCommandes = array_reverse($listeCommandes);
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
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
    <script src="section/Javascript/theme.js" defer></script>
</head>
<body>

    <?php include("section/Navigation.php"); ?>

    <div class="overlay-page">
        <main class="contenu-gestion">

            <section class="grille-stats">
                <article class="carte-stat">
                    <span class="libelle">Commandes totales</span>
                    <strong><?php echo $nombreCommandes; ?></strong>
                </article>

                <article class="carte-stat">
                    <span class="libelle">Commandes actives</span>
                    <strong><?php echo $nombreCommandesActives; ?></strong>
                </article>

                <article class="carte-stat">
                    <span class="libelle">Plats au menu</span>
                    <strong><?php echo $nombrePlats; ?></strong>
                </article>

                <article class="carte-stat">
                    <span class="libelle">Livreurs disponibles</span>
                    <strong><?php echo $nombreLivreursDisponibles; ?></strong>
                </article>
            </section>

            <section class="carte-chiffre">
                <span class="libelle">Chiffre d'affaires livré</span>
                <strong><?php echo number_format($chiffreAffaires, 2, ',', ' '); ?> €</strong>
            </section>

            <section class="grille-actions">
                <article class="carte-action">
                    <h2>Accès rapide</h2>
                    <p>Consultez et gérez toutes les commandes en cours.</p>
                    <a href="commandes.php" class="btn-action">Ouvrir les commandes</a>
                </article>

                <article class="carte-action">
                    <h2>Profil</h2>
                    <p>Accédez à votre profil et vos informations de compte.</p>
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
                            <?php if (empty($dernieresCommandes)) { ?>
                                <tr>
                                    <td colspan="4">Aucune commande enregistrée pour le moment.</td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($dernieresCommandes as $commande) { ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (isset($commande['id'])) {
                                                echo htmlspecialchars($commande['id']);
                                            } else {
                                                echo '—';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            if (isset($commande['client_nom'])) {
                                                echo htmlspecialchars($commande['client_nom']);
                                            } else {
                                                echo 'Client inconnu';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            if (isset($commande['statut'])) {
                                                echo htmlspecialchars($commande['statut']);
                                            } else {
                                                echo 'inconnu';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            $totalCommande = 0;

                                            if (isset($commande['total'])) {
                                                $totalCommande = (float) $commande['total'];
                                            }

                                            echo number_format($totalCommande, 2, ',', ' ') . ' €';
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>

</body>
</html>
