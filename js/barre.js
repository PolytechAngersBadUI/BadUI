function inclineDroite() {
    console.log("inclinedroite");
    var barre = document.getElementById("maBarre");
    if(barre.classList.contains('inclinaison-gauche')){
        barre.classList.remove("inclinaison-gauche");
        barre.classList.add("inclinaison-droite");
    }else if(barre.classList.contains('no-inclinaison')){
        barre.classList.remove("no-inclinaison");
        barre.classList.add("inclinaison-droite");
    }
}

function inclineGauche() {
    console.log("inclineGauche");
    var barre = document.getElementById("maBarre");
    if(barre.classList.contains('inclinaison-droite')){
        barre.classList.remove("inclinaison-droite");
        barre.classList.add("inclinaison-gauche");
    }else if(barre.classList.contains('no-inclinaison')){
        barre.classList.remove("no-inclinaison");
        barre.classList.add("inclinaison-gauche");
    }
}

function inclineMilieu() {
    console.log("inclineMilieu");
    var barre = document.getElementById("maBarre");
    if(barre.classList.contains('inclinaison-droite')){
        barre.classList.remove("inclinaison-droite");
        barre.classList.add("no-inclinaison");
    }else if(barre.classList.contains('inclinaison-gauche')){
        barre.classList.remove("inclinaison-gauche");
        barre.classList.add("no-inclinaison");
    }
}