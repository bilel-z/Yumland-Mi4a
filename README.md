# 🐼 KUNG FOOD - Projet Creative-Yumland

Dépôt du projet **KUNG FOOD**, un site web de restaurant chinois permettant de commander.

## 🚀 Prérequis et Lancement

Pour tester le projet en local sur votre machine, assurez-vous d'avoir **PHP** installé. 

1. Ouvrez votre terminal.
2. Naviguez jusque dans le dossier principal du site :
   ```bash
   cd PROJET2
   ```
3. Démarrez le serveur local PHP en tapant la commande suivante :
    ```bash
    php -S localhost:8000
    ```
4. Ouvrez votre navigateur web et accédez à l'URL suivante pour arriver sur la page d'accueil :
http://localhost:8000/Acceuil.php


# Phase 1

Création de la partie graphique côté client avec un affichage statique en HTML et CSS.

## Pages réalisées
Conformément au cahier des charges, les pages suivantes ont été intégrées :

* **Accueil (`Acceuil.html`)** : Présentation du site Kung Food, horaires et plats les plus commandés.
* **Menu (`Menu.html`)** : Présentation des plats avec barre de recherche et filtres par type, allergène et saveur.
* **Inscription (`Inscription.html`)** : Page permettant de créer un compte sur le site web.
* **Connexion (`page de connexion.html`)** : Page permettant de ce connecter à son profil.
* **Profil (`page de profil.html`)** : Page affichant les informations utilisateur et l'historique des commandes.
* **Administrateur (`Admin.html`)** : Liste des utilisateurs et accès aux profils.
* **Commandes (`commandes.html`)** : Interface pour le restaurateur affichant les statuts de préparation et livraison.
* **Livraison (`page de livraison.html`)** : Page pour le livreur avec informations client.
* **Notation (`Note.html`)** : Page permettant au client de noter le service et la qualité des plats et du restaurant.

# Phase 2

La phase 2 a consisté à transformer la maquette statique en une véritable application Web dynamique en **PHP**. Le projet a été réorganisé pour séparer les vues, les fonctions et le stockage des données, géré via des fichiers **JSON** côté serveur. Toutes les pages HTML ont été converties en PHP.

## Nouvelles fonctionnalités implémentées

* **Authentification et Inscription** : Création dynamique de comptes clients et connexion sécurisée avec redirection automatique selon le rôle de l'utilisateur (Client, Livreur, Restaurateur, Administrateur).
* **Page Menu (`Menu.php`)** : Génération de la carte du restaurant et des menus à partir de la lecture dynamique des fichiers de données.
* **Page Panier (`Panier.php`)** : Ajout et suppression d'articles, calcul du total, gestion du retrait et intégration de l'API de paiement CYBank.
* **Espace Restaurateur (`Gestion.php` / `commandes.php`)** : Tableau de bord permettant de suivre les commandes en temps réel, de modifier leur statut et de les attribuer à un livreur disponible.
* **Interface Livreur (`Livraison.php`)** : Affichage des détails de la commande attribuée (adresse, interphone) avec possibilité de clôturer la livraison ou de l'abandonner.
* **Espace Client (`Historique.php` / `Note.php`)** : Consultation de l'historique des commandes passées et possibilité de noter une commande une fois celle-ci livrée.
* **Administration (`Admin.php`)** : Interface permettant de gérer les utilisateurs (modification des rôles, statuts VIP/Premium, et blocage/déblocage de comptes).

## Architecture des données (JSON)

Plutôt qu'une base de données classique, le stockage s'effectue via des fichiers JSON structurés, manipulés directement en PHP :
* `utilisateurs.json` : Stocke les informations des profils (identifiants, contacts, rôles, statuts, dates de connexion).
* `plats.json` : Contient le catalogue du restaurant (prix, catégories, filtres d'allergènes/saveurs, et composition détaillée pour les menus).
* `commandes.json` : Enregistre le cycle de vie complet des commandes (articles choisis, montant, préparation, assignation du livreur et notes éventuelles).

# Phase 3

La phase 3 a consisté à rendre le site dynamique côté client grâce au langage **JavaScript** et aux requêtes asynchrones.

## Nouvelles fonctionnalités implémentées

* **Changement de thème (`theme.js`)** : Un bouton disponible sur toutes les pages permet de basculer entre le mode sombre (par défaut) et le mode clair. Le choix est sauvegardé dans un cookie et appliqué automatiquement au chargement de chaque page.

* **Mode accessibilité (`theme.js`)** : Un bouton Visibilité permet d'activer un mode texte en gras sur l'ensemble du site pour améliorer la lisibilité.

* **Validation des formulaires côté client (`validation.js`)** : Les formulaires d'inscription et de connexion vérifient les champs en temps réel sans recharger la page. La requête HTTP n'est envoyée au serveur que si tous les champs sont valides.

* **Affichage du mot de passe (`validation.js`)** : L'icone de l'oeil permet de faire basculer la visibilité du champ de mot de passe sur les pages de connexion, d'inscription et de profil.

* **Compteur de caractères (`compteur.js`)** : Les champs limités en taille affichent un compteur indiquant le nombre de caractères restants.

* **Filtres et tri asynchrones (`filtre.js`)** : Les filtres par type de plat, allergène et saveur envoient une requête asynchrone au serveur pour récupérer uniquement les plats correspondants et mettre à jour la grille sans recharger la page. Les tris s'effectuent directement sur les données déjà affichées.

* **Modification du profil en asynchrone (`profil.js`)** : Un utilisateur peut modifier ses informations personnelles et son mot de passe via un mode édition. Les modifications sont envoyées au serveur en connexion asynchrone et l'affichage est mis à jour sans rechargement.

* **Modification d'une commande (`ModifierCommande.php`)** : Un client peut ajouter ou retirer des articles sur une commande déjà payée mais pas encore en préparation. Le total se met à jour automatiquement. Si la commande devient plus chère, le client est redirigé vers CYBank pour payer le supplément.

* **Blocage/déblocage d'un utilisateur en asynchrone (`Admin.php`)** : L'administrateur peut bloquer ou débloquer un compte sans recharger la page. Si un utilisateur est bloqué, sa session est terminée immédiatement via une vérification périodique côté client (`check_bloque.php` utilisée toutes les 5 secondes).

# Phase 4

## Fonctionnalité innovante

* **Machine à jackpot (`Panier.php` `jackpot.php`)** : Les clients peuvent tenter leur chance une fois par jour via une machine à jackpot. En cas de victoire (trois pandas alignés), un bon de réduction est ajouté sur leur compte et peut être utilisé lors de la prochaine commande pour obtenir le plat le moins cher gratuitement. La machine peut être utilisé qu'une seul fois par jour.