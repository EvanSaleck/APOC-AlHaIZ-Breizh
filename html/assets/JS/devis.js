// Renvoyer à la page précédente (page de réservation)
document.querySelector('.retour').addEventListener('click', function() {
    window.location.href = 'index';
});

const section = document.querySelector("section"),
overlay = document.querySelector(".overlay"),
procederPaiement = document.querySelector(".proceder_paiement"),
modalBox = document.querySelector(".modal-box");

procederPaiement.addEventListener("click", () => {
    section.classList.add("active");

    // Faire disparaitre le bouton au bout de 3 secondes
    setTimeout(() => {
        section.classList.remove("active");
    }, 3000);
});

// Cacher la modale avec clic sur la modale
modalBox.addEventListener("click", () => {
    section.classList.remove("active"); 
});

// Cacher la modale avec clic sur le reste de la page
overlay.addEventListener("click", () => {
    section.classList.remove("active"); 
});