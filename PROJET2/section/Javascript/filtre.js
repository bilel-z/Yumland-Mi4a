let typePlat = document.getElementById('LabelType');
let Allergene = document.getElementById('LabelAllergene');
let Saveur = document.getElementById('LabelSaveur');
let boutton = document.getElementById('btnRecherche');
let boitePlat = document.getElementById('grillePlat');
let boiteMenu = document.getElementById('grilleMenu');
let recherche = document.getElementById('rechercheFor');

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
