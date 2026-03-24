<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KUNG FOOD - Menu</title>
        <link rel="stylesheet" href="CSS/styleMenu.css">
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
                        <a href="Acceuil.html">Accueil</a>
                    </li>
                    <li>
                        <a href="Menu.html">Menu</a>
                    </li>
                    <li>
                        <a href="page de connexion.html">Connexion</a>
                    </li>
                    <li>
                        <a href="page de profil.html">Profil</a>
                    </li>
                    <li>
                        <a href="page de livraison.html">Livraison</a>
                    </li>
                    <li>
                        <a href="Note.html">Notez-nous</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="effetNoir">
            <form method="get">
                <section class="PosBarre">
                    <div class="Titre">
                        <h1>Presentation des plats</h1>
                    </div>
                    
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
            <section class="Menu">
                <div class="MenuGrid">

                    <div class="choixPlat">
                        <div class="choixSel">
                            <div class="choixGluten choixVegetarien">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/riz_cantonais.jpg" alt="Image riz cantonais" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Riz Cantonais</h3>
                                        <p class="description">Riz sauté aux petits pois, jambon et œufs.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">8.50 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixEntree">
                        <div class="choixSucre">
                            <div class="choixGluten">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/TofuAigreDouce.jpg" alt="Image Tofu-Aigre-Douce" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Tofu frit sauce aigre-douce</h3>
                                        <p class="description">Tofu frit croustillant, nappé d’une sauce aigre‑douce parfumée et équilibrée.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">5.40 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixDessert">
                        <div class="choixGras">
                            <div class="choixGluten">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/beignetPomme.jpg" alt="Image Beignets de pomme" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Beignets de pomme</h3>
                                        <p class="description">Délicieux morceaux de pomme frits, nappés de caramel.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">3.30 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixPlat">
                        <div class="choixSel">
                            <div class="choixVegetarien choixGluten">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/NouilleChinoisAuPoulet.jpeg" alt="Image Nouilles chinoises" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Nouilles chinoises</h3>
                                        <p class="description">Nouilles chinoises sautées au wok, parfumées, légumes croquants et saveurs authentiques.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">9.80 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixEntree">
                        <div class="choixSel">
                            <div class="choixGluten choixVegetarien">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/RavioVapeur.jpg" alt="Image Raviolis vapeur" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Raviolis vapeur</h3>
                                        <p class="description">Petits raviolis tendres farcis au boeuf et légumes.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">6.50 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="choixPlat">
                        <div class="choixSel">
                            <div class="choixMer">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/PoisonAlaCantonaise.jpg" alt="Image Poisson vapeur à la cantonaise" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Poisson vapeur à la cantonaise</h3>
                                        <p class="description">Poisson vapeur à la cantonaise, chair délicate, gingembre frais et sauce soja parfumée.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">10.80 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixPlat">
                        <div class="choixSucre">
                            <div class="choixGluten choixVegetarien">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/pouletCaramel.jpg" alt="Image Poulet caramel" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Poulet caramel</h3>
                                        <p class="description">Poulet tendre nappé d’une sauce sucrée parfumée.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">11.20 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixDessert">
                        <div class="choixSel">
                            <div class="sansAler">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/geleeLitchi.jpg" alt="Image Gelée de litchi" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Gelée de litchi</h3>
                                        <p class="description">Dessert frais et léger au goût de litchi.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">4.00 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixPlat">
                        <div class="choixSel">
                            <div class="choixMer">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/RizFruitDeMer.jpg" alt="Image Riz sauté aux fruits de mer" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Riz sauté aux fruits de mer</h3>
                                        <p class="description">Riz sauté aux fruits de mer, wok parfumé mêlant crevettes, calamars et légumes croquants. </p>
                                        <div class="AjoutPanier">
                                            <span class="prix">8.50 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixDessert">
                        <div class="choixSucre">
                            <div class="choixLactose">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/RizAuLait.jpg" alt="Image Riz au lait vegan" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Riz au lait vegan</h3>
                                        <p class="description">Riz au lait crémeux végétal, douceur parfumée et gourmande.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">3.20 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixDessert">
                        <div class="choixSucre">
                            <div class="choixArachide">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/NougatChinois.jpg" alt="Image Nougat chinois" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Nougat chinois</h3>
                                        <p class="description">Nougat chinois croustillant, caramel léger et éclats d’amandes.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">3.20 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixEntree">
                        <div class="choixGras">
                            <div class="choixGluten choixVegetarien">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/nemPoulet.jpeg" alt="Image Nems au poulet" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Nems au poulet</h3>
                                        <p class="description">Rouleaux frits croustillants garnis de poulet.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">5.50 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixDessert">
                        <div class="choixSucre">
                            <div class="sansAler">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/perleCoco.jpeg" alt="Image Perles de coco" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Perles de coco</h3>
                                        <p class="description">Boules de riz gluant fourrées à la noix de coco.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">3.30 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixPlat">
                        <div class="choixGras">
                            <div class="choixGluten choixVegetarien">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/BoeufSauté.jpeg" alt="Image Bœuf sauté aux oignons" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Bœuf sauté aux oignons</h3>
                                        <p class="description">Bœuf tendre sauté avec oignons et sauce soja.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">12.00 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixEntree">
                        <div class="choixSucre">
                            <div class="sansAler">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/SaladeChou.jpg" alt="Image Salade de chou sucrée" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Salade de chou sucrée</h3>
                                        <p class="description">Chou croquant assaisonné sucré-vinaigré.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">5.00 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="choixEntree">
                        <div class="choixGras">
                            <div class="choixGluten choixVegetarien">
                                <div class="BoitePlat">
                                    <div class="PlatImage">
                                        <img src="image/Plats/brochetteBoeuf.jpg" alt="Image Brochettes de bœuf" />
                                    </div>
                                    <div class="BoiteContenu">
                                        <h3>Brochettes de bœuf</h3>
                                        <p class="description">Bœuf mariné grillé, tendre et parfumé.</p>
                                        <div class="AjoutPanier">
                                            <span class="prix">7.00 €</span>
                                            <button class="AjouterPanier">Ajouter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </section>
        </div>
    </body>
</html>