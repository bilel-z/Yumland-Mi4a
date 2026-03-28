<form action="Menu.php" method="get">
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
                <option value="" selected>Tout</option>
                <option value="Entree">Entrée</option>
                <option value="Plat">Plat principal</option>
                <option value="Dessert">Dessert</option>
            </select>
        </div>
        <div class="Allergène">
            <label for="LabelAllergene">Choisissez votre régime :</label>
            <select name="Allergene" id="LabelAllergene">
                <option value="" selected>Pas de régime</option>
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
                <option value="" selected>Tout</option>
                <option value="Sucre">Sucrée</option>
                <option value="Sel">Salé</option>
                <option value="Gras">Gras</option>
            </select>
        </div>
    </div>
</form>