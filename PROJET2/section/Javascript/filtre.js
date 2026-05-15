let typePlat = document.getElementById('LabelType');
let Allergene = document.getElementById('LabelAllergene');
let Saveur = document.getElementById('LabelSaveur');
let Tri = document.getElementById('LabelTri');
let boutton = document.getElementById('btnRecherche');
let boitePlat = document.getElementById('grillePlat');
let boiteMenu = document.getElementById('grilleMenu');
let recherche = document.getElementById('rechercheFor');

function appliqueTri(){
    let typeTri = Tri.value;
    let boites = [];
    // On crée une liste contenant les plats puis on trie le tableau en fonction du filtre
    for(let element of boitePlat.querySelectorAll('.BoitePlat')){
        boites.push(element);
    }
    if(typeTri == "prixCroissant"){
        boites.sort(function(a, b){
            return parseFloat(a.dataset.prix) - parseFloat(b.dataset.prix);
        });
    }
    else if(typeTri == "prixDecroissant"){
        boites.sort(function(a, b){
            return parseFloat(b.dataset.prix) - parseFloat(a.dataset.prix);
        });
    }
    else if(typeTri == "plusCommandes"){
        boites.sort(function(a, b){
            return parseFloat(b.dataset.nbcommande) - parseFloat(a.dataset.nbcommande);
        });
    }
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

function appliqueFiltre(){
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
        boiteMenu.innerHTML = contenu;
        appliqueTri();
    })
    .catch((error) => {
        console.log("Erreur dans la réponse de filtre.js")
    });
}

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
