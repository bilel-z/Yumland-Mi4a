<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="CSS/styleAdmin+commandes.css">
    <link rel="stylesheet" href="CSS/Variable.css">
    <link rel="icon" type="CSS/image/png" href="image/pandaLogo.png">
</head>
<body>




    <main class="contenu">
        <h1>Menu Administrateur</h1>

        <div class="filtres">
            <button class="filtres-bouton actif">Tous</button>
            <button class="filtres-bouton">Administrateurs</button>
            <button class="filtres-bouton">Sans commandes</button>
            <button class="filtres-bouton">Livreurs</button>
            <button class="filtres-bouton">commandes</button>
        </div>

<table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Commandes</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jean Martin</td>
                    <td> jean.martin@gmail.com</td>
                    <td>5</td>
                    <td>Actif</td>
                    <td><a href="Profil.php" class="Envoi">Voir profil</a></td>
                </tr>
                <tr>
                    <td>Marie Martin</td>
                    <td>marie@email.com</td>
                    <td>0</td>
                    <td>Inactif</td>
                    <td><a href="Profil.php" class="Envoi">Voir profil</a></td>
                </tr>
            </tbody>
        </table>
    </main>

</body>

</html>
