import * as utils from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    // utils.ThrowAlertPopup("message", "success");

    
    document.querySelector('.retour').addEventListener('click', function() {
        window.location.href = '/logements/';
    });
    
    document.querySelector('.boutonPrecedent').addEventListener('click', function() {
        window.location.href = '/logements/';
    });

    function updateReservationInfo() {
        let conteneur = document.querySelector('.infosReservationDev');
        
        let data = JSON.parse(sessionStorage.getItem('Logement'));
        // Récupération des données depuis le sessionStorage
        const dateArrivee = data.dateDebut;
        const dateDepart = data.dateFin;
        const nbOccupants = data.sctNbOccupants;
        const prixNuitTtc1 = parseFloat(data.tarifnuit); // Convertit en nombre pour utiliser toFixed
        const taxeSejour1 = parseFloat(data.taxeSejour); // Convertit en nombre pour utiliser toFixed
        const totalTtc1 = parseFloat(data.totalDevis); // Convertit en nombre pour utiliser toFixed
        const titreLogement = data.titrelogement;
        const imageLogement = data.image;
        const fraisService1 = parseFloat(data.fraisServices); // Convertit en nombre pour utiliser toFixed
        const prixParNuit1 = parseFloat(data.prixparnuit);
        
        document.getElementById('Nbnuits').innerText = data.nbNuits// Convertit en nombre pour utiliser toFixed
    
        // Conversion en nombre pour utiliser toFixed
        const prixNuitTtc = prixNuitTtc1.toFixed(2);
        const taxeSejour = taxeSejour1.toFixed(2);
        const totalTtc = totalTtc1.toFixed(2);
        const fraisService = fraisService1.toFixed(2);
        const prixParNuit = prixParNuit1.toFixed(2);
        
    
        // Mettre à jour les éléments avec les données de réservation
        let dateArriveeElement = document.getElementById('dateArrivee');
        let dateDepartElement = document.getElementById('dateFin');
        let nbOccupantElement = document.getElementById('sctNbOccupants');
        let prixNuitTtcElement = document.getElementById('prixNuitTtc');
        let taxeSejourElement = document.getElementById('taxeSejour');
        let totalTarifTtcElement = document.getElementById('totalTtc');
        let titreLogementElement = document.querySelector('.titreLogDevis');
        let imageLogementElement = document.querySelector('.photoLogResa');
        let fraisServiceElement = document.getElementById('fraisService');
        let prixParNuitElement = document.getElementById('prixParNuit');
    
        dateArriveeElement.textContent = dateArrivee;
        dateDepartElement.textContent = dateDepart;
        nbOccupantElement.textContent = `${nbOccupants} occupants`;
        prixNuitTtcElement.textContent = `${prixNuitTtc}€`;
        taxeSejourElement.textContent = `${taxeSejour}€`;
        totalTarifTtcElement.textContent = `${totalTtc}€`;
        titreLogementElement.textContent = titreLogement;
        imageLogementElement.src = imageLogement;
    
        // Mise à jour des frais de service et du prix par nuit
        fraisServiceElement.textContent = `${fraisService}€`;
        prixParNuitElement.textContent = `${prixParNuit}€`;
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

            let data = JSON.parse(sessionStorage.getItem('Logement'));
            
            // Création du formulaire pour l'envoi des données de la réservation
            let formData = new FormData();
            formData.append('dateArrivee', document.getElementById('dateArrivee').textContent);
            formData.append('dateDepart', document.getElementById('dateFin').textContent);
            formData.append('Nbnuits', data.nbNuits);
            formData.append('nbOccupants', document.getElementById('sctNbOccupants').textContent.split(" ")[0]);
            formData.append('taxeSejour', document.getElementById('taxeSejour').textContent.split("€")[0]);
            formData.append('totalTtc', document.getElementById('totalTtc').textContent.split("€")[0]);
            formData.append('fraisService', document.getElementById('fraisService').textContent.split("€")[0]);
            formData.append('tariftotalnuit', document.getElementById('prixNuitTtc').textContent.split("€")[0]);
            formData.append('id_logement', sessionStorage.getItem('idLogement'));

            // Envoi de la requête pour insérer la réservation
            fetch("/api/insertReservation", {
                method: "POST",
                body: formData,
            }).then(response => response.json())
                .then((data) => {
                console.log(data);                
                utils.ThrowAlertPopup("Paiement validé !", "success");

                sessionStorage.setItem('idresa', data);
                // on envoie sur la page de gestion des logements
                window.location.href = "/reservations/details";
            })
            
            // Disparition de la pop up au bout de 3 secondes
            setTimeout(() => {
                section.classList.remove("active");
            }, 3000);
        });
});