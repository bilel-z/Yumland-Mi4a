let typePlat = document.getElementById('LabelType');
let Allergene = document.getElementById('LabelAllergene');
let Saveur = document.getElementById('LabelSaveur');
let Tri = document.getElementById('LabelTri');
let boutton = document.getElementById('btnRecherche');
let boitePlat = document.getElementById('grillePlat');
let boiteMenu = document.getElementById('grilleMenu');
let recherche = document.getElementById('rechercheFor');


//Fonction qui applique un tri en fonction du prix croissant, decroissant ou en fonction du plat le plus commandé
function appliqueTri(){
    let typeTri = Tri.value;
    let boites = [];
    // On crée une liste contenant les plats puis on trie le tableau en fonction du filtre
    for(let element of boitePlat.querySelectorAll('.BoitePlat')){
        boites.push(element);
    }
    if(typeTri == "prixCroissant"){
        //Prix du moins cher au plus cher
        boites.sort(function(a, b){
            return parseFloat(a.dataset.prix) - parseFloat(b.dataset.prix);
        });
    }
    else if(typeTri == "prixDecroissant"){
        //Prix du plus cher au moins cher
        boites.sort(function(a, b){
            return parseFloat(b.dataset.prix) - parseFloat(a.dataset.prix);
        });
    }
    else if(typeTri == "plusCommandes"){
        //Du plat le plus commandé au moins commandé
        boites.sort(function(a, b){
            return parseFloat(b.dataset.nbcommande) - parseFloat(a.dataset.nbcommande);
        });
    }
    //On réinsère les cartes dans l'ordre
    for(let carte of boites){
        boitePlat.appendChild(carte);
    }

    //On fait la meme chose pour les menus
    let boitesMenu = [];
    for(let element of boiteMenu.querySelectorAll('.BoitePlat')){
        boitesMenu.push(element);
    }
    if(typeTri == "prixCroissant"){
        boitesMenu.sort(function(a, b){
            return parseFloat(a.dataset.prix) - parseFloat(b.dataset.prix);
        });
    }
    else if(typeTri == "prixDecroissant"){
        boitesMenu.sort(function(a, b){
            return parseFloat(b.dataset.prix) - parseFloat(a.dataset.prix);
        });
    }
    else if(typeTri == "plusCommandes"){
        boitesMenu.sort(function(a, b){
            return parseFloat(b.dataset.nbcommande) - parseFloat(a.dataset.nbcommande);
        });
    }
    for(let carte of boitesMenu){
        boiteMenu.appendChild(carte);
    }

}

//Fonction qui applique un filtre en fonction des choix de l'utilisateur
function appliqueFiltre(){
    //On recupere les composantes de l'URL et on fait un fetch ou en envoie les filtre avec de récupéré seuelemnt les plats correspondant avec le fetch
    let url = "?&recherche="+encodeURIComponent(recherche.value)+"&typePlat="+encodeURIComponent(typePlat.value)+"&Allergene="+encodeURIComponent(Allergene.value)+"&typeSaveur="+encodeURIComponent(Saveur.value);
    fetch("section/plat.php"+url)
    .then((response) => {
        if(!response){
            console.log("Erreur, pas de réponse");
            return "";
        }
        return response.text();
    })
    .then((contenu) => {
        //Affiche seulement les plats filtrés et triés
        boitePlat.innerHTML = contenu;
        appliqueTri();
    })
    .catch((error) => {
        console.log("Erreur dans la réponse de filtre.js")
    });

    fetch("section/menus.php"+url)
    .then((response) => {
        if(!response){
            console.log("Erreur, pas de réponse");
            return "";
        }
        return response.text();
    })
    .then((contenu) => {
        //Affiche seulement les menus filtrés et triés
        boiteMenu.innerHTML = contenu;
        appliqueTri();
    })
    .catch((error) => {
        console.log("Erreur dans la réponse de filtre.js")
    });
}

//Faire en sorte que la touche entrée valide la recherche
document.getElementById('rechercheFor').addEventListener('keydown', (touche) => {
    if (touche.key == 'Enter'){
        appliqueFiltre();
    }
});
boutton.addEventListener('click', appliqueFiltre);

typePlat.addEventListener("change",appliqueFiltre);
Allergene.addEventListener("change",appliqueFiltre);
Saveur.addEventListener("change",appliqueFiltre);
Tri.addEventListener("change", appliqueTri);
