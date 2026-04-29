function changerTheme(){
    let bouton = document.getElementById("bouttonTheme");
    let link = document.getElementById("theme");
    let nomCSS = link.getAttribute("href");
    
    if(nomCSS.includes("Variable.css")){
        bouton.innerHTML = "Mode sombre 🌙";
        link.setAttribute("href","CSS/VariableClair.css");
    }
    else if(nomCSS.includes("VariableClair.css")){
        bouton.innerHTML = "Mode clair ☀️";
        link.setAttribute("href","CSS/Variable.css");
    }
}