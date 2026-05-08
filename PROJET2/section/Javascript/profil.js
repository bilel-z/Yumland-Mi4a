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


    let donnees = {
        Prenom: document.getElementById("changerPrenom").value,
        Nom: document.getElementById("changerNom").value,
        Mail: document.getElementById("changerMail").value,
        Num: document.getElementById("changerNumero").value,
        Adresse: document.getElementById("changerAdresse").value,
        Interphone: document.getElementById("changerInterphone").value,
        Age: document.getElementById("changerAge").value
    };
    console.log(document.getElementById("changerAdresse"));
    console.log(donnees);
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
