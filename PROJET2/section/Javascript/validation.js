
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
        erreur = "Invalide : L'email est invalide";
        verif = false;
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
        erreur = "Invalide : le numero est invalide (il faut écrire sous forme XXXXXXXXXX)";
        verif = false;
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

function verificationMDP(champ, message) {
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
        
        if (!nombre) {
            erreur = "Invalide : le mot de passe doit contenir un chiffre ou plus";
            verif = false;
        }
        if (!minuscule) {
            erreur = "Invalide : le mot de passe doit contenir une lettre minuscule ou plus";
            verif = false;
        }
        if (!majuscule) {
            erreur = "Invalide : le mot de passe doit contenir une lettre majuscule ou plus";
            verif = false;
        }
        if (!charspec) {
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
function verifChangementMDP(ancien,nouveau,confirmation,message){
    let verif = true;
    message.style.display = "none";
    ancien.style.border = "1px solid var(--contour_gris)";
    nouveau.style.border = "1px solid var(--contour_gris)";
    confirmation.style.border = "1px solid var(--contour_gris)";
    if(nouveau.value.trim() != ""){
        if(ancien.value.trim() == ""){
            message.innerHTML = "Veuillez saisir votre mot de passe actuel";
            message.style.display = "block";
            ancien.style.border = "1px solid var(--contour_rouge)";
            verif = false;
        } else if(nouveau.value != confirmation.value){
            message.innerHTML = "Les nouveaux mots de passe ne correspondent pas.";
            message.style.display = "block";
            nouveau.style.border = "1px solid var(--contour_rouge)";
            confirmation.style.border = "1px solid var(--contour_rouge)";
            verif = false;
        }
    }
    else if(ancien.value.trim() != ""){
        message.innerHTML = "Veuillez entrer un nouveau mot de passe.";
        message.style.display = "block";
        nouveau.style.border = "1px solid var(--contour_rouge)";
        verif = false;
    }
    return verif;
}
	//inscription
document.addEventListener('DOMContentLoaded', function () {
    
    const mdpInput = document.getElementById('MdpFor');
    const emailInput = document.getElementById('MailFor');
    const prenomInput = document.getElementById('PrenomFor');
    const nomInput = document.getElementById('NomFor');
    const NumInput = document.getElementById('NumFor');
    const AdresseInput = document.getElementById('AdresseFor');
    const interphoneInput = document.getElementById('InterphoneFor');
    const inscriptionForm = document.getElementById('inscriptionForm');
    const togglePassword = document.getElementById('togglePassword');
    
    
    if (mdpInput) {
        mdpInput.addEventListener('input', function () {
            verificationMDP(this, document.getElementById('erreurMdp'));
        });
    }
    
    if (emailInput) {
        emailInput.addEventListener('input', function () {
            verificationMail(this, document.getElementById('erreurEmail'));
        });
    }
    
    if (prenomInput) {
        prenomInput.addEventListener('input', function () {
            verificationChampNormal(this, document.getElementById('erreurPrenom'));
        });
    }
    
    if (nomInput) {
        nomInput.addEventListener('input', function () {
            verificationChampNormal(this, document.getElementById('erreurNom'));
        });
    }
    
    if (NumInput) {
        NumInput.addEventListener('input', function () {
            verificationNumero(this, document.getElementById('erreurNum'));
        });
    }
    
    if (AdresseInput) {
        AdresseInput.addEventListener('input', function () {
            verificationChampNormal(this, document.getElementById('erreurAdresse'));
        });
    }
    
    if (interphoneInput) {
        interphoneInput.addEventListener('input', function () {
            verificationChampNormal(this, document.getElementById('erreurInterphone'));
        });
    }
    
    //verif finale validité inscription
    
    if (inscriptionForm) {
        inscriptionForm.addEventListener('submit', function (e) {
            let emailValide = verificationMail(emailInput, document.getElementById('erreurEmail'));
            let mdpValide = verificationMDP(mdpInput, document.getElementById('erreurMdp'));
            let nomValide = verificationChampNormal(nomInput, document.getElementById('erreurNom'));
            let prenomValide = verificationChampNormal(prenomInput, document.getElementById('erreurPrenom'));
            let numValide = verificationNumero(NumInput, document.getElementById('erreurNum'));
            let adresseValid = verificationChampNormal(AdresseInput, document.getElementById('erreurAdresse'));
            
            if (!emailValide || !mdpValide || !nomValide || !prenomValide || !numValide || !adresseValid) {
                e.preventDefault();
            }
        });
    }
    
    //cache mot de passe
    if (togglePassword && mdpInput) {
        togglePassword.addEventListener('click', function (e) {
            e.preventDefault();
            
            if (mdpInput.type === 'password') {
                mdpInput.type = 'text';
                togglePassword.textContent = '🙈';
            } else {
                mdpInput.type = 'password';
                togglePassword.textContent = '👁️';
            }
        });
    }
});

	//connexion
document.addEventListener('DOMContentLoaded', function () {
    
    const mdpInput = document.getElementById('mdp');
    const emailInput = document.getElementById('email');
    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.getElementById('togglePassword');
    
    if (mdpInput) {
        mdpInput.addEventListener('input', function () {
            verificationMDP(this, document.getElementById('erreurMdp'));
        });
    }
    
    if (emailInput) {
        emailInput.addEventListener('input', function () {
            verificationMail(this, document.getElementById('erreurEmail'));
        });
    }
    
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            let emailValid = verificationMail(emailInput, document.getElementById('erreurEmail'));
            let mdpValid = verificationMDP(mdpInput, document.getElementById('erreurMdp'));
            
            if (!emailValid || !mdpValid) {
                e.preventDefault();
            }
        });
    }
    
    if (togglePassword && mdpInput) {
        togglePassword.addEventListener('click', function (e) {
            e.preventDefault();
            
            if (mdpInput.type === 'password') {
                mdpInput.type = 'text';
                togglePassword.textContent = '🙈';
            } else {
                mdpInput.type = 'password';
                togglePassword.textContent = '👁️';
            }
        });
    }
});
