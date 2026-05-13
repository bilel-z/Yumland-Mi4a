// Récupère tous les champs qui ont une limite de caractères
const listeChamps = document.querySelectorAll('input[maxlength][data-compteur]');

function mettreAJourCompteur(champ) {
    const longueur        = champ.value.length;
    const maximum         = parseInt(champ.getAttribute('maxlength'));
    const restant         = maximum - longueur;
    const idCompteur      = champ.getAttribute('data-compteur');
    const elementCompteur = document.getElementById(idCompteur);

    if (!elementCompteur) return;

    elementCompteur.textContent = restant + ' / ' + maximum + ' caractères restants';

    elementCompteur.classList.remove('compteur-ok', 'compteur-attention', 'compteur-critique');

    const tauxRemplissage = longueur / maximum;

    if (tauxRemplissage < 0.7) {
        elementCompteur.classList.add('compteur-ok');
    } else if (tauxRemplissage < 0.9) {
        elementCompteur.classList.add('compteur-attention');
    } else {
        elementCompteur.classList.add('compteur-critique');
    }
}

listeChamps.forEach(function(champ) {
    mettreAJourCompteur(champ);

    champ.addEventListener('input', function() {
        mettreAJourCompteur(champ);
    });
});
