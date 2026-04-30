function changerTheme(){
    let bouton = document.getElementById("bouttonTheme");
    let link = document.getElementById("theme");
    let nomCSS = link.getAttribute("href");
    
    if(nomCSS.includes("Variable.css")){
        bouton.innerHTML = "Mode sombre 🌙";
        link.setAttribute("href","CSS/VariableClair.css");
        enregistreCookie("theme","clair");
    }
    else if(nomCSS.includes("VariableClair.css")){
        bouton.innerHTML = "Mode clair ☀️";
        link.setAttribute("href","CSS/Variable.css");
        enregistreCookie("theme","sombre");
    }
}

function enregistreCookie(nom,valeur){
    document.cookie = nom + "=" + valeur + "; path=/;";
}

function lireCookie(nom,origine){
    let tab = document.cookie.split("; ");
    for(let e of tab){
        let [cle,valeur] = e.split("=");
        if(cle == nom){
            return valeur;
        }
    }
    return origine;
}

function themeChargement(){
    let theme = lireCookie("theme","sombre");
    let link = document.getElementById("theme");
    let nomCSS = link.getAttribute("href");
    let bouton = document.getElementById("bouttonTheme");
    if(theme == "clair"){
        bouton.innerHTML = "Mode sombre 🌙";
        link.setAttribute("href","CSS/VariableClair.css");
    }
    else if(theme == "sombre"){
        bouton.innerHTML = "Mode clair ☀️";
        link.setAttribute("href","CSS/Variable.css");
    }
    else{
        console.log("Erreur avec le cookie du thème");
    }
}

themeChargement();