// Renvoyer à la page précédente (page de réservation)
document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelector('.retour').addEventListener('click', function() {
        window.location.href = 'index';
    });
    
    document.querySelector('.boutonPrecedent').addEventListener('click', function() {
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

    var logementData = JSON.parse(sessionStorage.getItem('logement'));

    console.log(logementData);

    // Fonction pour mettre à jour les éléments HTML avec les données de réservation
    function updateReservationInfo() {
        // Sélectionner le conteneur principal
        let conteneur = document.querySelector('.infosReservationDev');

        console.log(conteneur)

        let tt = conteneur.querySelectorAll('.infosReservationDev > div:not(.deuxiemeBarre)');
        console.log(tt)

        // Accéder aux éléments spécifiques dans le conteneur
        let dateArriveeElement = tt[0].querySelector('#date_arrivee');
        let dateDepartElement = tt[1].querySelector('.date_depart');
        let nbOccupantElement = tt[2].querySelector('.nb_occupant');
        let prixNuitTtcElement = tt[3].querySelector('.prix_nuit_ttc');
        let taxeSejourElement = tt[4].querySelector('.taxe_sejour');
        let totalTarifTtcElement = tt[5].querySelector('.total_tarif_ttc');

        // Mettre à jour les éléments avec les données de réservation
        dateArriveeElement.textContent = logementData.date_arrivee;
        dateDepartElement.textContent = logementData.date_depart;
        nbOccupantElement.textContent = `${logementData.nb_occupant} occupants`;
        prixNuitTtcElement.textContent = `${logementData.prix_nuit_ttc}€`;
        taxeSejourElement.textContent = `${logementData.taxe_sejour}€`;
        totalTarifTtcElement.textContent = `${(parseFloat(logementData.prix_nuit_ttc) * 12 + parseFloat(logementData.taxe_sejour)).toFixed(2)}€`; // Calcul du total pour 12 nuits
    }

    updateReservationInfo();
});