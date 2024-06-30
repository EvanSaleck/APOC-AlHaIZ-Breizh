import { ThrowAlertPopup, resetErrors } from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    var listeLogements = document.getElementById('listeLogements');

    // au changement d'un input date, on grise les dates antérieures
    let dateDebut = document.getElementById('dateDebut');
    dateDebut.addEventListener('change', function() {
        let dateFin = document.getElementById('dateFin');
        dateFin.min = dateDebut.value;
    });

    // pareil pour dateFin
    let dateFin = document.getElementById('dateFin');
    dateFin.addEventListener('change', function() {
        let dateDebut = document.getElementById('dateDebut');
        dateDebut.max = dateFin.value;
    });


    // on récupère les logements du propriétaire
    fetch('/api/getLogementsByProprietaireId')
    .then(response => response.json())
    .then(data => {
        data.forEach(logement => {
            // on crée un div pour chaque logement avec un label et un checkbox
            let div = document.createElement('div');
        
            let label = document.createElement('label');
            label.style.cursor = 'pointer';
        
            let checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.value = logement.id_logement;  
            checkbox.name = 'logements[]';  
        
            let text = document.createTextNode(logement.titre);
        
            label.appendChild(checkbox);
            label.appendChild(text);
            div.appendChild(label);
        
            listeLogements.appendChild(div);                 
        });
        
    });

    // on ajoute un event listener sur le formulaire
    let form = document.getElementById('formICal');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this); 

        if(validateFormData(e)) {
            // si on est sur la page d'edition, on update, sinon on crée
            if (window.location.pathname.match(/^\/reservations\/abonnements\/iCal\/edit\/\d+\/$/) || window.location.pathname.match(/^\/reservations\/abonnements\/iCal\/edit\/\d+$/)) {
                let id = window.location.pathname.split('/')[5];
                updateAbonnement(id, formData);
            } else {
                createAbonnement(formData);
            }
        }
    });

    // pour véirifier que les données entrées sont correctes
    function validateFormData(e) {
        resetErrors();
        let isValid = true;

        let titre = document.getElementById('titreAbo');
        if (titre.value.length > 50) {
            e.preventDefault();
            let spanError = document.getElementById('errorTitreAbo');
            spanError.innerText = 'Le titre ne doit pas dépasser 50 caractères';
            isValid = false;
        }

        if (titre.value === '') {
            e.preventDefault();
            let spanError = document.getElementById('errorTitreAbo');
            spanError.innerText = 'Veuillez entrer un titre';
            isValid = false;
        }

    
        let checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let checked = false;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checked = true;
            }
        });
        if (!checked) {
            e.preventDefault();
            let spanError = document.getElementById('errorListeLogements');
            spanError.innerText = 'Veuillez sélectionner au moins un logement';
            isValid = false;  
        } else {
            let checkedBoxes = [];
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    checkedBoxes.push(checkbox.value);
                }
            });
        }
    
        // on vérifie que la date de début est entrée
        let dateDebut = document.getElementById('dateDebut');
        if (dateDebut.value === '') {
            e.preventDefault();
            let spanError = document.getElementById('errorDateDebut');
            spanError.innerText = 'Veuillez entrer une date de début';
            isValid = false;
        }
    
        // on vérifie que la date de fin est entrée
        let dateFin = document.getElementById('dateFin');
        if (dateFin.value === '') {
            e.preventDefault();
            let spanError = document.getElementById('errorDateFin');
            spanError.innerText = 'Veuillez entrer une date de fin';
            isValid = false;  
        }
    
        // on vérifie que la date de début est antérieure à la date de fin
        if (dateDebut.value > dateFin.value) {
            e.preventDefault();
            let spanError = document.getElementById('errorDateFin');
            spanError.innerText = 'La date de fin doit être postérieure à la date de début';
            isValid = false; 
        }
    
        // on vérifie que la date de fin est postérieure à la date de début
        if (dateFin.value < dateDebut.value) {
            e.preventDefault();
            let spanError = document.getElementById('errorDateFin');
            spanError.innerText = 'La date de fin doit être postérieure à la date de début';
            isValid = false;
        }
    
        return isValid;
    }


    // si on est sur la page d'edition, on prérempli les champs et on modifie le titre et le bouton
    if (window.location.pathname.match(/^\/reservations\/abonnements\/iCal\/edit\/\d+\/$/) || window.location.pathname.match(/^\/reservations\/abonnements\/iCal\/edit\/\d+$/)) {
        let id = window.location.pathname.split('/')[5];
        console.log(id);
        fetch('/api/reservations/abonnements/iCal/getDataICal/' + id)
        .then(response => response.json())
        .then(data => {
            let titre = document.getElementById('titreAbo');
            titre.value = data.titre;
            let dateDebut = document.getElementById('dateDebut');
            dateDebut.value = data.date_debut;
            let dateFin = document.getElementById('dateFin');
            dateFin.value = data.date_fin;
            
            let logements = data.logements.split(',');
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                if (logements.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
        });

        let titre = document.getElementById('titre');
        titre.innerText = 'Modifier l\'abonnement';

        let submit = document.getElementById('submit');
        submit.value = 'Modifier l\'abonnement';
    }


    function createAbonnement(formData) {
        // on envoie les données du formulaire pour créer un nouvel abonnement
        fetch("/api/reservations/abonnements/iCal/new", {
            method: "POST",
            body: formData,
          })  
            .then((response) => {
                return response.json();
            })
            .then(data => {
                if (data === true ) {
                    let message  = "Abonnement créé";
                    ThrowAlertPopup(message, 'success');
                    localStorage.setItem('alertPopup', JSON.stringify({ message: message, type: 'success' }));
                    window.location.href = '/reservations/abonnements/liste';
                } else {
                    ThrowAlertPopup('Erreur lors de la l\enregistrement de votre abonnement, veuillez réessayer plus tard. <br> Si le problème persiste, merci de contacter un administrateur', 'error');
                }
            });
    }

    function updateAbonnement(id, formData) {
        // on envoie les données du formulaire pour modifier un abonnement
        fetch("/api/reservations/abonnements/iCal/edit/" + id, {
            method: "POST",
            body: formData,
          })  
            .then((response) => {
                return response.json();
            })
            .then(data => {
                if (data === true ) {
                    let message  = "Abonnement modifié";
                    ThrowAlertPopup(message, 'success');
                    localStorage.setItem('alertPopup', JSON.stringify({ message: message, type: 'success' }));
                    window.location.href = '/reservations/abonnements/liste';
                } else {
                    ThrowAlertPopup('Erreur lors de la l\enregistrement de votre abonnement, veuillez réessayer plus tard. <br> Si le problème persiste, merci de contacter un administrateur', 'error');
                }
            });
    }
});