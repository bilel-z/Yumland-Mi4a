<?php
echo '
<div class="BarreRecherche">
    <div class="Recherche">
            <label for="rechercheFor"></label>
            <input id="rechercheFor" name="recherche" placeholder="Recherchez un plat !">
            <button type="'.((basename($_SERVER['PHP_SELF'])=="Acceuil.php") ? "submit" : "button").'" id="btnRecherche" title="Boutton Recherche">
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
                <option value="Boisson">Boisson</option>
            </select>
        </div>
        <div class="Allergène">
            <label for="LabelAllergene">Choisissez votre régime :</label>
            <select name="Allergene" id="LabelAllergene">
                <option value="" selected>Pas de régime</option>
                <option value="Vegetarien">Végétarien</option>
                <option value="Vegan">Vegan</option>
                <option value="Halal">Halal</option>
                <option value="Gluten">Sans gluten</option>
                <option value="Lactose">Sans lactose</option>
                <option value="Oeuf">Sans œuf</option>
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
                <option value="Epice">Épicé</option>
                <option value="Gras">Gras</option>
            </select>
        </div>
        <div class="Tri">
        <label for="LabelTri">Trier par :</label>
        <select name="tri" id="LabelTri">
            <option value="" selected>Aucun tri</option>
            <option value="prixCroissant">Prix croissant</option>
            <option value="prixDecroissant">Prix décroissant</option>
            <option value="plusCommandes">Les plus commandés</option>
        </select>
        </div>    
    </div>
</div>
'
;?>