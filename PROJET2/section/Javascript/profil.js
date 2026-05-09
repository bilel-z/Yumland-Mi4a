let prenomErreur = document.getElementById("prenomErreur");
let nomErreur = document.getElementById("nomErreur");
let mailErreur = document.getElementById("mailErreur");
let numErreur = document.getElementById("numErreur");
let adresseErreur = document.getElementById("adresseErreur");
let interphoneErreur = document.getElementById("interphoneErreur");
let ageErreur = document.getElementById("ageErreur");
let mdpErreur = document.getElementById("mdpErreur");

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
    let v7 = verifChangementMDP(changerAncienMDP,changerNouveauMDP,changerConfirmeMDP,mdpErreur);
    if(v1 && v2 && v3 && v4 && v5 && v6 && v7){
        fetch("section/editionProfil.php", {method : "POST", body : JSON.stringify(donnees), headers : {"Content-Type": "application/json"}})
        .then((response) => {
            if(!response){
                console.log("Erreur, pas de réponse");
                return "";
            }
            return response.json();
        })
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
                console.log(contenu.message);
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
        })
        .catch((error) => {
            console.log("Erreur dans la réponse de filtre.js")
        });
    }
}


function verificationChampNormal(champ,message){
    let verif = true;
    if(champ.value.trim() == ""){
        message.innerHTML = "Invalide : Le champs ne doit pas être vide";
        verif = false;
        champ.style.border = "1px solid var(--contour_rouge)";
        message.style.display = "block";
    }
    if(verif){
        champ.style.border = "1px solid var(--contour_gris)";
        message.style.display = "none";
    }
    return verif;
}

function verificationMail(champ,message){
    let verif = true;
    let erreur = "";
    let mail = champ.value.trim();
    if(mail == ""){
        erreur = "Invalide : Le champs ne doit pas être vide";
        verif = false;
    }
    else if(!mail.includes("@") || !mail.includes(".")){
        if(verif){
            erreur = "Invalide : L'email est invalide";
            verif = false;
        }
        else{
            erreur += " et est invalide";
        }
    }
    message.innerHTML = erreur;
    if(!verif){
        champ.style.border = "1px solid var(--contour_rouge)";
        message.style.display = "block";
    }
    else{
        champ.style.border = "1px solid var(--contour_gris)";
        message.style.display = "none";
    }
    return verif;
}

function verificationNumero(champ,message){
    let verif = true;
    let erreur = "";
    let num = champ.value.trim();
    if(num == ""){
        erreur = "Invalide : Le champs ne doit pas être vide";
        verif = false;
    }
    else if(num.length != 10 || isNaN(num)){
        if(verif){
            erreur = "Invalide : le numero est invalide (il faut écrire sous forme XXXXXXXXXX)";
            verif = false;
        }
        else{
            erreur += " et est invalide (il faut écrire sous forme XXXXXXXXXX)";
        }
    }
    message.innerHTML = erreur;
    if(!verif){
        champ.style.border = "1px solid var(--contour_rouge)";
        message.style.display = "block";
    }
    else{
        champ.style.border = "1px solid var(--contour_gris)";
        message.style.display = "none";
    }
    return verif;

}



function verificationMDP(champ,message){
    //A faire
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