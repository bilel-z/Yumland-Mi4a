
function verificationChampNormal(champ, message) {
    let verif = true;
    if (champ.value.trim() == "") {
        message.innerHTML = "Invalide : Le champs ne doit pas être vide";
        verif = false;
        champ.style.border = "2px solid var(--contour_rouge)";
        champ.classList.add('error');
        message.style.display = "block";
    }
    if (verif) {
        champ.style.border = "2px solid var(--contour_gris)";
        champ.classList.remove('error');
        message.style.display = "none";
    }
    return verif;
}

function verificationMail(champ, message) {
    let verif = true;
    let erreur = "";
    let mail = champ.value.trim();
    if (mail == "") {
        erreur = "Invalide : Le champs ne doit pas être vide";
        verif = false;
    }
    else if (!mail.includes("@") || !mail.includes(".")) {
        if (verif) {
            erreur = "Invalide : L'email est invalide";
            verif = false;
        }
        else {
            erreur += " et est invalide";
        }
    }
    message.innerHTML = erreur;
    if (!verif) {
        champ.style.border = "2px solid var(--contour_rouge)";
        champ.classList.add('error');
        message.style.display = "block";
    }
    else {
        champ.style.border = "2px solid var(--contour_gris)";
        champ.classList.remove('error');
        message.style.display = "none";
    }
    return verif;
}

function verificationNumero(champ, message) {
    let verif = true;
    let erreur = "";
    let num = champ.value.trim();
    if (num == "") {
        erreur = "Invalide : Le champs ne doit pas être vide";
        verif = false;
    }
    else if (num.length != 10 || isNaN(num)) {
        if (verif) {
            erreur = "Invalide : le numero est invalide (il faut écrire sous forme XXXXXXXXXX)";
            verif = false;
        }
        else {
            erreur += " et est invalide (il faut écrire sous forme XXXXXXXXXX)";
        }
    }
    message.innerHTML = erreur;
    if (!verif) {
        champ.style.border = "2px solid var(--contour_rouge)";
        champ.classList.add('error');
        message.style.display = "block";
    }
    else {
        champ.style.border = "2px solid var(--contour_gris)";
        champ.classList.remove('error');
        message.style.display = "none";
    }
    return verif;
}
function verificationMDP(champ,message){
    let verif = true;
    let erreur = "";
    let num = champ.value.trim();
    let nombre = false;
    let minuscule = false;
    let majuscule = false;
    let charspec = false;
    
    if (num == "") {
        erreur = "Invalide : Le champs ne doit pas être vide";
        verif = false;
    }
    else if (num.length < 8) {
        erreur = "Invalide : le mot de passe doit contenir 8 caractères ou plus";
        verif = false;
    }
    else {
        for (let char of champ.value) {
            if (/\d/.test(char)) {
                nombre = true;
            }
            else if (/[a-z]/.test(char)) {
                minuscule = true;
            }
            else if (/[A-Z]/.test(char)) {
                majuscule = true;
            }
            else {
                charspec = true;
            }
        }
        
        if (!nombre){
            erreur = "Invalide : le mot de passe doit contenir un chiffre ou plus";
            verif = false;
        }
        if(!minuscule){
            erreur = "Invalide : le mot de passe doit contenir une lettre minuscule ou plus";
            verif = false;
        }
        if(!majuscule){
            erreur = "Invalide : le mot de passe doit contenir une lettre majuscule ou plus";
            verif = false;
        }
        if(!charspec) {
            erreur = "Invalide : le mot de passe doit contenir un caractère spécial ou plus";
            verif = false;
        }
    }
    
    message.innerHTML = erreur;
    if (!verif) {
        champ.style.border = "2px solid var(--contour_rouge)";
        champ.classList.add('error');
        message.style.display = "block";
    }
    else {
        champ.style.border = "2px solid var(--contour_gris)";
        champ.classList.remove('error');
        message.style.display = "none";
    }
    return verif;
}
 