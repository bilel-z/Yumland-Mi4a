<?php 
include_once("section/Fonction/fonction.php");
securiserCookieSession();
session_start(); 
if (!isset($_SESSION["user"]) || ($_SESSION["user"]["role"] ?? "") != "administrateur") {
    header('Location: Connexion.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="CSS/styleAdmin+commandes.css">
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
    <script src="section/Javascript/theme.js" defer></script>
    <script src="section/Javascript/fonction.js" defer></script>
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!requeteInterne()) { http_response_code(403); exit("Requête refusée."); }
    $userId = $_POST["user-id"] ?? "";
    $userTrouve = null;

    foreach ($users as &$user) {
        if ($user["id"] == $userId) {
            if (isset($_POST["role"])) {
                $rolesValides = ["client", "livreur", "restaurateur", "administrateur"];
                if (in_array($_POST["role"], $rolesValides, true)) {
                    $user["role"] = $_POST["role"];
                }
            }
            if (isset($_POST["statut"])) {
                $statutsValides = ["Classique", "Premium", "VIP"];
                if (in_array($_POST["statut"], $statutsValides, true)) {
                    $user["statut"] = $_POST["statut"];
                }
            }
            if (isset($_POST["bloque"])) $user["bloquer"] = (bool)intval($_POST["bloque"]);
            $userTrouve = $user;
            break;
        }
    }
    unset($user);

    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

    if (isset($_POST["bloque"])) {
        header('Content-Type: application/json');
        echo json_encode([
            "success" => true,
            "bloque"  => $userTrouve["bloquer"] ?? false
        ]);
        exit();
    }

    header("Location: Admin.php");
    exit();
}

$filtre = $_GET["role"] ?? "tous";

if ($filtre !== "tous") {
    $users = array_filter($users, function($user) use ($filtre) {
        return isset($user["role"]) && $user["role"] === $filtre;
    });
}
?>

    <div style="position: fixed; top: 20px; right: 30px; z-index: 1000;">
        <a href="section/deconnexion.php" class="Envoi" style="text-decoration: none;">🔓 Déconnexion</a>
    </div>

    <main class="contenu">
        <h1 style="color: white;">Menu Administrateur</h1>

        <div class="filtres">
            <a href="Admin.php?role=tous" class="filtres-bouton <?= $filtre === "tous" ? "actif" : "" ?>">Tous</a>
            <a href="Admin.php?role=administrateur" class="filtres-bouton <?= $filtre === "administrateur" ? "actif" : "" ?>">Administrateurs</a>
            <a href="Admin.php?role=restaurateur" class="filtres-bouton <?= $filtre === "restaurateur" ? "actif" : "" ?>">restaurateurs</a>
            <a href="Admin.php?role=livreur" class="filtres-bouton <?= $filtre === "livreur" ? "actif" : "" ?>">Livreurs</a>
            <a href="Admin.php?role=client" class="filtres-bouton <?= $filtre === "client" ? "actif" : "" ?>">Clients</a>
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
               <?php foreach($users as $user): ?>
                <tr>
                    <td>
                        <a href="Profil.php?id=<?= $user['id'] ?>"> 
                            <?= htmlspecialchars($user["Nom"] . ' ' . $user["Prenom"]) ?>
                        </a>
                    </td>
                    <td> 
                        <form method="post">
                            <select name="role" onchange="this.form.submit()">
                               <option value="client" <?= $user["role"]==="client" ? "selected":"" ?>>Client</option>
                                <option value="livreur" <?= $user["role"]==="livreur" ? "selected":"" ?>>livreur</option>
                                <option value="restaurateur" <?= $user["role"]==="restaurateur" ? "selected":"" ?>>restaurateur</option>
                                <option value="administrateur" <?= $user["role"]==="administrateur" ? "selected":"" ?>>administrateur</option>
                            </select>
                            <input type="hidden" name="user-id" value="<?=$user["id"]?>">
                        </form>
                    </td>
                    <td><?= htmlspecialchars($user["derniere_connexion"]) ?></td>
                    <td>
                        <form method="post">
                            <select name="statut" onchange="this.form.submit()"> 
                                <?php $statut = $user["statut"] ?? "Classique"; ?>
                                <option value="Classique" <?= $statut==="Classique" ? "selected":"" ?>>Classique</option>
                                <option value="Premium"   <?= $statut==="Premium"   ? "selected":"" ?>>Premium</option>
                                <option value="VIP"       <?= $statut==="VIP"       ? "selected":"" ?>>VIP</option>
                            </select>
                            <input type="hidden" name="user-id" value="<?= $user["id"] ?>">
                        </form>
                    </td>
                    <td>
                        <button
                            class="Envoi btn-bloque"
                            data-user-id="<?= $user["id"] ?>"
                            data-bloque="<?= $user["bloquer"] ? '1' : '0' ?>"
                        >
                            <?= $user["bloquer"] ? "🔓 Débloquer" : "🔒 Bloquer" ?>
                        </button>
                    </td>
                </tr>
               <?php endforeach; ?>
            </tbody>
        </table>
    </main>

</body>
</html>