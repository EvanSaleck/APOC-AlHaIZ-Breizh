import { resetErrors } from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    console.log('carre');
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

    fetch('/api/getLogementsByProprietaireId')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        data.forEach(logement => {
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

    // on vérifie qu'au moins un logement est sélectionné
    let form = document.getElementById('formICal');
    form.addEventListener('submit', function(e) {
        resetErrors();
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
        }

        // on vérifie que la date de fin est entrée
        let dateFin = document.getElementById('dateFin');
        if (dateFin.value === '') {
            e.preventDefault();
            let spanError = document.getElementById('errorDateFin');
            spanError.innerText = 'Veuillez entrer une date de fin';
        }

        // on verifie que la date de debut est antérieure à la date de fin
        if (dateDebut.value > dateFin.value) {
            e.preventDefault();
            let spanError = document.getElementById('errorDateFin');
            spanError.innerText = 'La date de fin doit être postérieure à la date de début';
        }

        // on verifie que la date de fin est postérieure à la date de début
        if (dateFin.value < dateDebut.value) {
            e.preventDefault();
            let spanError = document.getElementById('errorDateFin');
            spanError.innerText = 'La date de fin doit être postérieure à la date de début';
        }
    });
});
