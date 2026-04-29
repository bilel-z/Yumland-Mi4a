<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KUNG FOOD - Accueil</title>
        <link rel="stylesheet" href="CSS/styleAccueil.css">
        <link rel="stylesheet" href="CSS/BarreNav.css">
        <link rel="stylesheet" href="CSS/Recherche.css">
        <link rel="stylesheet" id="theme" href="CSS/Variable.css">
        <link rel="icon" type="image/png" href="image/pandaLogo.png">
        <script src="section/Javascript/theme.js" defer></script>
    </head>
    <body>
        <?php include 'section/Navigation.php'; ?>

        <section>
            <div class="LogoCorp">
                <img src="image/pandaLogo.png" alt="logo du restaurant" />
                <div class="nomResto">KUNG FOOD</div>
                <div class="typeResto">Restaurant Chinois</div>
            </div>
            <div class="Presentation">
                <p>Préparez-vous à un festin légendaire ! Chez Kung Food, nous servons des portions dignes du Guerrier Dragon. Entrez dans notre arène du goût pour un moment de pure convivialité.</p>
                <p>Nos chefs manient le wok avec la précision de Maître Shifu. Ici, tout est frais et cuisiné à la minute. Pas d'ingrédient secret, juste du talent et de la passion !</p>
                <p>Notre carte est aussi variée que les styles des Cinq Cyclones. Des raviolis vapeur aux plats épicés, chaque bouchée vous fera crier « Skadoosh » de plaisir.</p>
                <p>Rejoignez-nous facilement au restaurant. Pour régler votre festin, nous acceptons les Cartes Bleues et les espèces. (Désolé, nous ne prenons pas les pièces d'or !).</p>
            </div>

        <div class="PlatPrefere">
            <h1 class="TitrePlatPrefere">Les plats les plus commandés</h1>
            <div class="GrillePlatCelebre">

                <a href="Menu.php">
                    <div class="BoitePlat">
                        <div class="PlatImage">
                            <img src="image/Plats/brochetteBoeuf.jpg" alt="Image Brochettes de bœuf" />
                        </div>
                        <div class="BoiteContenu">
                            <h3>Brochettes de bœuf</h3>
                            <p class="description">Bœuf mariné grillé, tendre et parfumé.</p>
                        </div>
                    </div>
                </a>

                <a href="Menu.php">
                    <div class="BoitePlat">
                        <div class="PlatImage">
                            <img src="image/Plats/riz_cantonais.jpg" alt="Image riz cantonais" />
                        </div>
                        <div class="BoiteContenu">
                            <h3>Riz Cantonais</h3>
                            <p class="description">Riz sauté aux petits pois, jambon et œufs.</p>
                        </div>
                    </div>
                </a>

                <a href="Menu.php">
                    <div class="BoitePlat">
                        <div class="PlatImage">
                            <img src="image/Plats/RavioVapeur.jpg" alt="Image Raviolis vapeur" />
                        </div>
                        <div class="BoiteContenu">
                            <h3>Raviolis vapeur</h3>
                            <p class="description">Petits raviolis tendres farcis au boeuf et légumes.</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>    
        </section>

        <section>
            <div class="Horaire">
                <h1 class="titreHoraire">Horaire d'ouverture</h1>
                <div class="tableauHoraire">
                    <div class="blocTableau">
                        <div>Lundi</div>
                        <div>11h30-14h30   19h00-23h00</div>
                    </div>
                    <div class="blocTableau">
                    <div>Mardi</div>
                        <div>11h30-14h30   19h00-23h00</div>
                    </div>
                    <div class="blocTableau">
                        <div>Mercredi</div>
                        <div>11h30-14h30   19h00-23h00</div>
                    </div>
                    <div class="blocTableau">
                        <div>Jeudi</div>
                        <div>11h30-14h30   19h00-23h00</div>
                    </div>
                    <div class="blocTableau">
                        <div>Vendredi</div>
                        <div>11h30-14h30   19h00-23h00</div>
                    </div>
                    <div class="blocTableau">
                        <div>Samedi</div>
                        <div>11h30-14h30   19h00-23h00</div>
                    </div>
                    <div class="blocTableau">
                        <div>Dimanche</div>
                        <div>12h00-15h00   19h00-22h30</div>
                    </div>
                </div>
            </div>
        </section>
            <form action="Menu.php" method="get">
                <section class="PosBarre">
                        <?php include 'section/BarreMenu.php'; ?>
                </section>
            </form>
        <footer>
            <div>Ⓒ COPYRIGHTY 2026 - Mentions légales</div>
        </footer>
    </body>
</html>