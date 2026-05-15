
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
function modeEdition(){
    let listeLecture = document.querySelectorAll(".lecture");
    let listeEdition = document.querySelectorAll(".edition");
    for(let element of listeLecture){
        element.style.display = "none";
    }
    for(let element of listeEdition){
        element.style.display = "block";
    }
}

function modeLecture(){
    let bouttonEdition = document.getElementById("bouttonModifier");
    let listeLecture = document.querySelectorAll(".lecture");
    let listeEdition = document.querySelectorAll(".edition");
    for(let element of listeLecture){
        element.style.display = "block";
    }
    for(let element of listeEdition){
        element.style.display = "none";
    }
    bouttonEdition.style.display = "flex";
}

function modifierProfil(){
    
    let prenomErreur = document.getElementById("prenomErreur");
let nomErreur = document.getElementById("nomErreur");
let mailErreur = document.getElementById("mailErreur");
let numErreur = document.getElementById("numErreur");
let adresseErreur = document.getElementById("adresseErreur");
let interphoneErreur = document.getElementById("interphoneErreur");
let ageErreur = document.getElementById("ageErreur");
let mdpErreur = document.getElementById("mdpErreur");

    let changerPrenom = document.getElementById("changerPrenom");
    let changerNom = document.getElementById("changerNom");
    let changerMail = document.getElementById("changerMail");
    let changerNumero = document.getElementById("changerNumero");
    let changerAdresse = document.getElementById("changerAdresse");
    let changerInterphone = document.getElementById("changerInterphone");
    let changerAge = document.getElementById("changerAge");
    let changerAncienMDP = document.getElementById("changerAncienMDP");
    let changerNouveauMDP = document.getElementById("changerNouveauMDP");
    let changerConfirmeMDP = document.getElementById("changerConfirmeMDP");

    let donnees = {
        Prenom: changerPrenom.value,
        Nom: changerNom.value,
        Mail: changerMail.value,
        Num: changerNumero.value,
        Adresse: changerAdresse.value,
        Interphone: changerInterphone.value,
        Age: changerAge.value,
        AncienMDP: changerAncienMDP.value,
        NouveauMDP: changerNouveauMDP.value 
    };
    
    let v1 = verificationChampNormal(changerPrenom, prenomErreur);
    let v2 = verificationChampNormal(changerNom, nomErreur);
    let v3 = verificationMail(changerMail, mailErreur);
    let v4 = verificationNumero(changerNumero, numErreur);
    let v5 = verificationChampNormal(changerAdresse, adresseErreur);
    let v6 = verificationChampNormal(changerAge, ageErreur);
    let v7 = verifChangementMDP(changerAncienMDP, changerNouveauMDP, changerConfirmeMDP, mdpErreur);
    
    if(v1 && v2 && v3 && v4 && v5 && v6 && v7){
        fetch("section/editionProfil.php", {
            method: "POST", 
            body: JSON.stringify(donnees), 
            headers: {"Content-Type": "application/json"}
        })
        .then((response) => response.json())
        .then((contenu) => {
            if(contenu.succes == true) {
                let champsPrenom = document.getElementById("champsPrenom");
                let champsNom = document.getElementById("champsNom");
                let champsMail = document.getElementById("champsMail");
                let champsNum = document.getElementById("champsNum");
                let champsAdresse = document.getElementById("champsAdresse");
                let champsInterphone = document.getElementById("champsInterphone");
                let champsAge = document.getElementById("champsAge");
                let Titre = document.getElementById("titreProfil");

                champsPrenom.innerHTML = "<strong>Prenom :</strong> " + donnees.Prenom;
                champsNom.innerHTML = "<strong>Nom :</strong> " + donnees.Nom;
                champsMail.innerHTML = "<strong>Email :</strong> " + donnees.Mail;
                champsNum.innerHTML = "<strong>Téléphone :</strong> " + donnees.Num;
                champsAdresse.innerHTML = "<strong>Adresse :</strong> " + donnees.Adresse;
                champsInterphone.innerHTML = "<strong>Interphone :</strong> " + donnees.Interphone;
                champsAge.innerHTML = "<strong>Date de naissance :</strong> " + donnees.Age;
                Titre.innerHTML = donnees.Prenom + " " + donnees.Nom;
                changerAncienMDP.value = "";
                changerNouveauMDP.value = "";
                changerConfirmeMDP.value = "";
                
                modeLecture();
            }
            else{
                if(contenu.code == "MailDoublon"){
                    changerMail.style.border = "1px solid var(--contour_rouge)";
                    mailErreur.innerHTML = "Cette adresse mail est déjà utilisée par un autre compte";
                    mailErreur.style.display = "block";
                }
                else if(contenu.code == "ErreurMDP"){
                    changerAncienMDP.style.border = "1px solid var(--contour_rouge)";
                    mdpErreur.innerHTML = contenu.message;
                    mdpErreur.style.display = "block";
                }
            }
        });
    }
}


document.addEventListener('DOMContentLoaded', function () {
    

    const originalInput = document.getElementById('changerAncienMDP');
    const togglePassword = document.getElementById('togglePassword');
    
    if (togglePassword && originalInput) {
        togglePassword.addEventListener('click', function (e) {
            e.preventDefault();
            originalInput.type = originalInput.type === 'password' ? 'text' : 'password';
            togglePassword.textContent = originalInput.type === 'password' ? '👁️' : '🙈';
        });
    }
    

    const mdpInput = document.getElementById('changerNouveauMDP');
    const togglePassword1 = document.getElementById('togglePassword1');
    
    if (togglePassword1 && mdpInput) {
        togglePassword1.addEventListener('click', function (e) {
            e.preventDefault();
            mdpInput.type = mdpInput.type === 'password' ? 'text' : 'password';
            togglePassword1.textContent = mdpInput.type === 'password' ? '👁️' : '🙈';
        });
    }
    
    const confirmInput = document.getElementById('changerConfirmeMDP');
    const togglePassword2 = document.getElementById('togglePassword2');
    
    if (togglePassword2 && confirmInput) {
        togglePassword2.addEventListener('click', function (e) {
            e.preventDefault();
            confirmInput.type = confirmInput.type === 'password' ? 'text' : 'password';
            togglePassword2.textContent = confirmInput.type === 'password' ? '👁️' : '🙈';
        });
    }
    const inputsValidation = [
        { id: 'changerPrenom', erreur: 'prenomErreur', fonction: verificationChampNormal },
        { id: 'changerNom', erreur: 'nomErreur', fonction: verificationChampNormal },
        { id: 'changerMail', erreur: 'mailErreur', fonction: verificationMail },
        { id: 'changerNumero', erreur: 'numErreur', fonction: verificationNumero },
        { id: 'changerAdresse', erreur: 'adresseErreur', fonction: verificationChampNormal },
        { id: 'changerAge', erreur: 'ageErreur', fonction: verificationChampNormal }
    ];

    inputsValidation.forEach(item => {
        let element = document.getElementById(item.id);
        if (element) {
            element.addEventListener('input', function() {
                let spanErreur = document.getElementById(item.erreur);
                item.fonction(element, spanErreur);
            });
        }
    });

    const mdpInputs = ['changerAncienMDP', 'changerNouveauMDP', 'changerConfirmeMDP'];
    mdpInputs.forEach(id => {
        let el = document.getElementById(id);
        if(el) {
            el.addEventListener('input', function() {
                validerGroupeMotDePasse();
            });
        }
    });
});

function setupTogglePassword(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(toggleId);
    if (toggle && input) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            input.type = input.type === 'password' ? 'text' : 'password';
            toggle.textContent = input.type === 'password' ? '👁️' : '🙈';
        });
    }
}

// Fonction de validation pour le changement de mot de passe
function validerGroupeMotDePasse() {
    const ancien = document.getElementById('changerAncienMDP');
    const nouveau = document.getElementById('changerNouveauMDP');
    const confirme = document.getElementById('changerConfirmeMDP');
    const message = document.getElementById('mdpErreur');

    if (ancien.value === "" && nouveau.value === "" && confirme.value === "") {
        message.style.display = "none";
        [ancien, nouveau, confirme].forEach(el => el.style.border = "2px solid var(--contour_gris)");
        return true;
    }

    if (nouveau.value !== "") {
        let forceValide = verificationMDP(nouveau, message); // Utilise votre fonction de force
        if (!forceValide) return false; 
    }


    return verifChangementMDP(ancien, nouveau, confirme, message);
}