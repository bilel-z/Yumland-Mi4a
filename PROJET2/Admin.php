<?php session_start(); ?>
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


<?php

$file = "section/JSON/utilisateurs.json";

if (!file_exists($file)) {
    die("Erreur : fichier JSON introuvable à : " . $file);
}

$json = file_get_contents($file);
$users = json_decode($json, true);

if ($users === null) {
    die("Erreur : JSON invalide — " . json_last_error_msg());
}
if ($_SERVER["REQUEST_METHOD"] ==="POST"){
	$userId = $_POST["user-id"];
	foreach($users as &$user){
		if ($user["id"] == $userId) {
			if (isset($_POST["role"])){
				$user["role"] =$_POST["role"];
			}
			if (isset($_POST["statut"])){
				$user["statut"] =$_POST["statut"];
			}
			if (isset($_POST["bloque"])){
				$user["bloquer"] =(bool)intval($_POST["bloque"]);
			}
			break;
		}
	}
	file_put_contents($file,json_encode($users, JSON_PRETTY_PRINT));
	header("location: Admin.php");
	exit();
}
?>

    <main class="contenu">
        <h1>Menu Administrateur</h1>

        <div class="filtres">
            <button class="filtres-bouton actif">Tous</button>
            <button class="filtres-bouton">Administrateurs</button>
            <button class="filtres-bouton">restaurateurs</button>
            <button class="filtres-bouton">Livreurs</button>
            <button class="filtres-bouton">Clients</button>

        </div>

<table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>role</th>
                    <th>derniere_connexion</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               <?php foreach($users as $user): // Enlève le & (référence inutile et dangereuse ici) ?>
    <?php $profilData = urlencode(json_encode($user)); ?>
    <tr>
        <td>
            <a href="Profil.php?id=<?= $user['id'] ?>"> <!-- Passe seulement l'id -->
                <?= htmlspecialchars($user["Nom"] . ' ' . $user["Prenom"]) ?>
            </a>
        </td>
                    <td> 
                        <form method="post">
                            <select name="role" onchange="this.form.submit()">
                               <option value="client" <?= $user["role"]==="client" ? "selected":""?>>Client</option>
                                <option value="livreur" <?= $user["role"]==="livreur" ? "selected":""?>>livreur</option>
                                <option value="restaurateur" <?= $user["role"]==="restaurateur" ? "selected":""?>>restaurateur</option>
                                <option value="administrateur" <?= $user["role"]==="administrateur" ? "selected":""?>>administrateur</option>
                            </select>
                            <input type="hidden" name="user-id" value="<?=$user["id"]?>">
                        </form>
                    </td>
                    <td><?= htmlspecialchars($user["derniere_connexion"]) ?></td>
        <td>
            <form method="post">
                <select name="statut" onchange="this.form.submit()"> <!-- name="statut" pas "role" -->
                    <?php $statut = $user["statut"] ?? "classique"; // Valeur par défaut ?>
                    <option value="Classique" <?= $statut==="classique" ? "selected":"" ?>>Classique</option>
                    <option value="Premium"   <?= $statut==="Premium"   ? "selected":"" ?>>Premium</option>
                    <option value="VIP"       <?= $statut==="VIP"       ? "selected":"" ?>>VIP</option>
                </select>
                <input type="hidden" name="user-id" value="<?= $user["id"] ?>">
            </form>
        </td>
                    <td>
                       <form method="post">
    <input type="hidden" name="user-id" value="<?= $user["id"] ?>">
    <input type="hidden" name="bloque" value="<?= $user["bloquer"] ? 0 : 1 ?>">
    <button type="submit" class="Envoi">
    <?= $user["bloquer"] ? "🔓 Débloquer" : "🔒 Bloquer" ?>
</button>
        
</form>
                    </td>
                </tr>
               <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>

</html>

