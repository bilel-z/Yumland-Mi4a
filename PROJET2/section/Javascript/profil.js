let prenomErreur = document.getElementById("prenomErreur");
let nomErreur = document.getElementById("nomErreur");
let mailErreur = document.getElementById("mailErreur");
let numErreur = document.getElementById("numErreur");
let adresseErreur = document.getElementById("adresseErreur");
let interphoneErreur = document.getElementById("interphoneErreur");
let ageErreur = document.getElementById("ageErreur");

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

    let donnees = {
        Prenom: document.getElementById("changerPrenom").value,
        Nom: document.getElementById("changerNom").value,
        Mail: document.getElementById("changerMail").value,
        Num: document.getElementById("changerNumero").value,
        Adresse: document.getElementById("changerAdresse").value,
        Interphone: document.getElementById("changerInterphone").value,
        Age: document.getElementById("changerAge").value
    };
    let v1 = verificationChampNormal(changerPrenom, prenomErreur);
    let v2 = verificationChampNormal(changerNom, nomErreur);
    let v3 = verificationMail(changerMail, mailErreur);
    let v4 = verificationNumero(changerNumero, numErreur);
    let v5 = verificationChampNormal(changerAdresse, adresseErreur);
    let v6 = verificationChampNormal(changerAge, ageErreur);
    if(v1 && v2 && v3 && v4 && v5 && v6){
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

                modeLecture();
            }
            else{
                console.log(contenu.message);
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