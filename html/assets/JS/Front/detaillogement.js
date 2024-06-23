document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelector('#btnRetourMobile').addEventListener('click', function() {
        window.location.href = 'index';
    });
    

    var infosReservation = JSON.parse(sessionStorage.getItem('reservation'));

    console.log(infosReservation);

    // Fonction pour mettre à jour les éléments HTML avec les données de réservation
    function updateReservationInfo() {
        let conteneur = document.querySelector('.infosReservationDev');

        console.log(conteneur)

        let tt = conteneur.querySelectorAll('.infosReservationDev > div:not(.deuxiemeBarre)');
        console.log(tt)

        // Utilisation des sélecteurs d'ID pour mettre à jour les éléments avec les données de réservation
        let dateArriveeElement = document.getElementById('dateArrivee');
        let dateDepartElement = document.getElementById('dateFin');
        let nbOccupantElement = document.getElementById('sctNbOccupants');
        let prixNuitTtcElement = document.getElementById('prixNuitTtc');
        let taxeSejourElement = document.getElementById('taxeSejour');
        let totalTarifTtcElement = document.getElementById('totalTtc');

        // Mettre à jour les éléments avec les données de réservation
        dateArriveeElement.textContent = infosReservation.date_arrivee;
        dateDepartElement.textContent = infosReservation.date_depart;
        nbOccupantElement.textContent = `${infosReservation.nb_occupant} occupants`;
        prixNuitTtcElement.textContent = `${infosReservation.prix_nuit_ttc}€`;
        taxeSejourElement.textContent = `${infosReservation.taxe_sejour}€`;
        totalTarifTtcElement.textContent = `${infosReservation.total_tarif_ttc}€`;

    }

    updateReservationInfo();

    const section = document.querySelector("section"),
        overlay = document.querySelector(".overlay"),
        procederPaiementButton = document.querySelector(".proceder_paiement"),
        modalBox = document.querySelector(".modal-box");

        procederPaiementButton.addEventListener("click", function(e) {
            e.preventDefault();
            
            const carteCredit = document.getElementById("carteCredit").value;
            const expiration = document.getElementById("expiration").value.split("/");
            const cvv = document.getElementById("cvv").value;
            const nom = document.getElementById("nom").value;
            const codePostal = document.getElementById("codePostal").value;
        
            const regexNumeros = /^[0-9]+$/;
            if (!regexNumeros.test(carteCredit)) {
                alert("Le numéro de carte doit contenir uniquement des chiffres.");
                return;
            }
        
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1;
            const expirationMonth = parseInt(expiration[0]);
            const expirationYear = parseInt(expiration[1]);
        
            // Vérifier le format de la date
            if (expiration.length !== 2 || isNaN(expirationMonth) || isNaN(expirationYear)) {
                alert("La date d'expiration doit être au format MM/AAAA.");
                return;
            }
        
            // Vérifier date supérieure
            if (expirationYear < currentYear || (expirationYear === currentYear && expirationMonth <= currentMonth)) {
                alert("La date d'expiration doit être ultérieure à la date actuelle.");
                return;
            }
        
            // Vérifier validite CB
            const maxExpirationYear = currentYear + 3;
            if (expirationYear > maxExpirationYear) {
                alert("La date d'expiration ne peut pas dépasser trois ans à partir de la date actuelle.");
                return;
            }
        
            // Vérifier code CVV
            const regexCVV = /^[0-9]{3,4}$/;
            if (!regexCVV.test(cvv)) {
                alert("Le code CVV doit contenir uniquement des chiffres et avoir une longueur de 3 ou 4 caractères.");
                return;
            }
        
            // Empêcher le nom vide
            if (nom.trim() === "") {
                alert("Veuillez saisir un nom.");
                return;
            }

            if (nom.trim().toLowerCase() === "tottereau" || nom.trim().toLowerCase() === "guigner" || nom.trim().toLowerCase() === "le gall" ) {
                alert("Bravo champion !");
            }
        
            // Vérifier le code postal
            const regexCodePostal = /^[0-9]{5}$/;
            if (!regexCodePostal.test(codePostal)) {
                alert("Le code postal doit contenir 5 chiffres.");
                return;
            }
        
            // Affichage de la pop up après validation
            console.log("Toutes les vérifications sont passées, affichage de la popup de paiement.");
            section.classList.add("active");
            // Disparition de la pop up au bout de 3 secondes
            setTimeout(() => {
                section.classList.remove("active");
            }, 3000);
        });
});
