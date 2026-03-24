<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KUNG FOOD - Accueil</title>
        <link rel="stylesheet" href="CSS/styleAccueil.css">
        <link rel="stylesheet" href="CSS/BarreNav.css">
        <link rel="stylesheet" href="CSS/Recherche.css">
    </head>
    <body>
        <nav>
            <div class="logo">
                <img src="image/pandaLogo.png" alt="Logo restaurant panda" />
            </div>
            <div class="navigation">
                <ul>
                    <li>
                        <a href="Acceuil.php">Accueil</a>
                    </li>
                    <li>
                        <a href="Menu.php">Menu</a>
                    </li>
                    <li>
                        <a href="Connexion.php">Connexion</a>
                    </li>
                    <li>
                        <a href="Profil.php">Profil</a>
                    </li>
                    <li>
                        <a href="Livraison.php">Livraison</a>
                    </li>
                    <li>
                        <a href="Note.php">Notez-nous</a>
                    </li>
                </ul>
            </div>
        </nav>
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

                <a href="Menu.html">
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
            <form method="get">
                <section class="PosBarre">
                        <div class="Recherche">
                            <label for="rechercheFor"></label>
                            <input id="rechercheFor" name="recherche" placeholder="Recherchez un plat !">
                            <button type="submit" title="Boutton Recherche">
                                <img src="image/Loupe.png" alt="LogoRecherche">
                            </button>
                        </div>
                        <div class="filtre">
                            <div class="Type">
                                <label for="LabelType">Choisissez le type de plat :</label>
                                <select name="typePlat" id="LabelType">
                                    <option value="ToutT" selected>Tout</option>
                                    <option value="Entree">Entrée</option>
                                    <option value="Plat">Plat principal</option>
                                    <option value="Dessert">Dessert</option>
                                </select>
                            </div>
                            <div class="Allergène">
                                <label for="LabelAllergene">Choisissez votre régime :</label>
                                <select name="Allergene" id="LabelAllergene">
                                    <option value="Sans" selected>Pas de régime</option>
                                    <option value="Vegetarien">Végétarien</option>
                                    <option value="Gluten">Sans gluten</option>
                                    <option value="Lactose">Sans lactose</option>
                                    <option value="Cacahuete">Sans arachide</option>
                                    <option value="Mer">Sans fruit de mer</option>
                                </select>
                            </div>
                            <div class="Saveur">
                                <label for="LabelSaveur">Choisissez la saveur :</label>
                                <select name="typeSaveur" id="LabelSaveur">
                                    <option value="ToutS" selected>Tout</option>
                                    <option value="Sucre">Sucrée</option>
                                    <option value="Sel">Salé</option>
                                    <option value="Gras">Gras</option>
                                </select>
                            </div>
                        </div>
                </section>
            </form>
        <footer>
            <div>Ⓒ COPYRIGHTY 2026 - Mentions légales</div>
        </footer>
    </body>
</html>