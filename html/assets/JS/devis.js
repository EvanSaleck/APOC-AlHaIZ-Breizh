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
    /* Paiement par carte bancaire */
    const procederPaiementButton = document.querySelector(".proceder_paiement");
procederPaiementButton.addEventListener("click", function(e) {
    e.preventDefault();

    const carteCredit = document.getElementById("carteCredit").value;
    const expiration = document.getElementById("expiration").value.split("/");
    const cvv = document.getElementById("cvv").value;
    const nom = document.getElementById("nom").value;
    const codePostal = document.getElementById("codePostal").value; // Assurez-vous que cette ligne est correctement fermée

    const luhnCheck = num => {
        const arr = `${num}`
         .split('')
         .reverse()
         .map(x => Number.parseInt(x));
        const lastDigit = arr.shift();
        let sum = arr.reduce(
            (acc, val, i) =>
                i % 2!== 0? acc + val : acc + ((val *= 2) > 9? val - 9 : val),
            0
        );
        sum += lastDigit;
        return sum % 10 === 0;
    };

    // Card type checks
    const cardTypes = {
        "visa": /^4\d{12}(?:\d{3})?$/,
        "mastercard": /^(?:5[1-5]\d{14}|2(?:2[1-9]|[3-6][0-9]{2})\d{12})$/
    };
    let cardTypeMatched = false;
    for (let type in cardTypes) {
        if (cardTypes[type].test(carteCredit)) {
            console.log(`La carte est une ${type}.`);
            cardTypeMatched = true;
            break;
        }
    }

    // Existing validations...
    const regexNumeros = /^[0-9]+$/;
    if (!regexNumeros.test(carteCredit)) {
        alert("Le numéro de carte doit contenir uniquement des chiffres.");
        return;
    }

    const regexExpiration = /^(0[1-9]|1[0-2])\/(19|20)\d{2}$/;
    if (!regexExpiration.test(`${expiration[0]}/${expiration[1]}`)) {
        alert("La date d'expiration doit être au format MM/AAAA.");
        return;
    }

    const currentDate = new Date();
    const expirationDate = new Date(`20${expiration[1]}`, expiration[0] - 1);
    if (expirationDate <= currentDate) {
        alert("La carte n'est pas encore valide.");
        return;
    }

    const threeYearsFromNow = new Date(currentDate.getFullYear() + 3, currentDate.getMonth(), currentDate.getDate());
    if (expirationDate < threeYearsFromNow) {
        alert("La carte n'est valide que pendant au moins trois ans.");
        return;
    }

    if (!cvv ||!nom ||!codePostal) { // Assurez-vous que cette condition est correctement fermée
        alert("Veuillez vérifier les informations de paiement.");
        return;
    }

    // Only display the payment confirmation popup if all validations pass
    if (luhnCheck(carteCredit) && cardTypeMatched) {
        alert("Paiement validé!");
    } else {
        alert("Il semble y avoir eu une erreur avec votre carte de crédit. Veuillez réessayer.");
    }
})});
