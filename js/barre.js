function inclineDroite() {
    var barre = document.getElementById("maBarre");
    barre.classList.remove("inclinaison-gauche"); // Supprime la classe pour l'inclinaison vers la gauche
    barre.classList.add("inclinaison-droite"); // Ajoute la classe pour l'inclinaison vers la droite
}

function inclineGauche() {
    var barre = document.getElementById("maBarre");
    barre.classList.remove("inclinaison-droite"); // Supprime la classe pour l'inclinaison vers la droite
    barre.classList.add("inclinaison-gauche"); // Ajoute la classe pour l'inclinaison vers la gauche
}