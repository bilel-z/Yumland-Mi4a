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
* **Page Panier (`Panier.php` / `traitement_panier.php`)** : Ajout et suppression d'articles, calcul du total, gestion du retrait et intégration de l'API de paiement CYBank.
* **Espace Restaurateur (`Gestion.php` / `commandes.php`)** : Tableau de bord permettant de suivre les commandes en temps réel, de modifier leur statut et de les attribuer à un livreur disponible.
* **Interface Livreur (`Livraison.php`)** : Affichage des détails de la commande attribuée (adresse, interphone) avec possibilité de clôturer la livraison ou de l'abandonner.
* **Espace Client (`Historique.php` / `Note.php`)** : Consultation de l'historique des commandes passées et possibilité de noter une commande une fois celle-ci livrée.
* **Administration (`Admin.php`)** : Interface permettant de gérer les utilisateurs (modification des rôles, statuts VIP/Premium, et blocage/déblocage de comptes).

## Architecture des données (JSON)

Plutôt qu'une base de données classique, le stockage s'effectue via des fichiers JSON structurés, manipulés directement en PHP :
* `utilisateurs.json` : Stocke les informations des profils (identifiants, contacts, rôles, statuts, dates de connexion).
* `plats.json` : Contient le catalogue du restaurant (prix, catégories, filtres d'allergènes/saveurs, et composition détaillée pour les menus).
* `commandes.json` : Enregistre le cycle de vie complet des commandes (articles choisis, montant, préparation, assignation du livreur et notes éventuelles).

