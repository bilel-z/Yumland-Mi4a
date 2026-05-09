<?php
ob_start();
session_start();

if (!isset($_SESSION["user"])) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(["bloque" => false]);
    exit();
}

$file = __DIR__ . "/JSON/utilisateurs.json";
$users = json_decode(file_get_contents($file), true);

$userId = $_SESSION["user"]["id"];
$bloque = false;

foreach ($users as $user) {
    if ((string)$user["id"] === (string)$userId) {
        $bloque = filter_var($user["bloquer"] ?? false, FILTER_VALIDATE_BOOLEAN);
        break;
    }
}

ob_clean();
header('Content-Type: application/json');
echo json_encode(["bloque" => $bloque]);
exit();