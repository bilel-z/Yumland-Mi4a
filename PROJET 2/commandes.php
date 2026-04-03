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
        <h1>Menu Commandes</h1>

        <div class="filtres">
            <button class="filtres-bouton actif">Tous</button>
            <button class="filtres-bouton">préparation</button>
            <button class="filtres-bouton">livraison</button>
            <button class="filtres-bouton">livrés</button>
        </div>

<table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>commande</th>
                    <th>numéro de commmandes</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jean Martin</td>
                    <td>riz cantonnais</td>
                    <td>5</td>
                    <td>livraison</td>
                    <td>
					<button class="Envoi">livraison</button>
					<button class="Envoi rouge">livrés</button>
					</td>
                </tr>
                <tr>
                    <td>Marie Martin</td>
                    <td>brochette de boeuf</td>
                    <td>12</td>
                    <td>préparation</td>
                    <td>
					<button class="Envoi">livraison</button>
					<button class="Envoi rouge">livrés</button>
					</td>
					
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>

