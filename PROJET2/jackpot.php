<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: Connexion.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jackpot – Kung Food</title>
    <link rel="stylesheet" id="theme" href="CSS/Variable.css">
	 <link rel="stylesheet" href="CSS/BarreNav.css">
	<link rel="stylesheet" id="theme" href="CSS/jackpot.css">
    <link rel="icon" type="image/png" href="image/pandaLogo.png">
	<script src="section/Javascript/jackpot.js" defer></script>

    
</head>
<body>
    <div class="page-wrap">
        <div class="header">
            <div class="header-logo">JACKPOT</div>
            <div class="header-sub">Kung Food · Machine à sous</div>
        </div>

        <div class="machine">
            <div class="reels-row">
                <div class="reel" id="r0"><img src="image/pandaLogo.png" style="width:80px;height:80px;object-fit:cover;border-radius:8px;"></div>
                <div class="reel" id="r1">🍜</div>
                <div class="reel" id="r2">🦐</div>
		
            </div>

            <div class="result-msg" id="msg">Tentez votre chance !</div>

            <button class="spin-btn" id="spinBtn">Tourner</button>
        </div>

        <div class="history-wrap" id="histWrap" style="display:none">
            <div class="history-label">Derniers tirages</div>
            <div class="history-list" id="histList"></div>
        </div>

        <a href="Acceuil.php" class="back-link">← Retour à l'accueil</a>
    </div>

    <script src="section/Javascript/check_bloque.js" defer></script>
    
</body>
</html>
