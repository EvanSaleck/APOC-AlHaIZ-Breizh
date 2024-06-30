import { ThrowAlertPopup } from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    // on récupère le propriétaire connecté
    let proprio = JSON.parse(sessionStorage.getItem("Proprio"));
    document.getElementById('bonjour').innerHTML = "Bonjour " + proprio.prenom + ",";
    const storedPopup = localStorage.getItem('alertPopup');
    let message, type;
    
    // si une pop up est stockée en local storage, on l'affiche
    if (storedPopup) {
        ({ message, type } = JSON.parse(storedPopup));
        ThrowAlertPopup(message, type);
        localStorage.removeItem('alertPopup');
    }


    // Récupération des logements du propriétaire
    fetch('/api/getLogementsByProprietaireId')
    .then(response => {
          if (!response.ok) {
              throw new Error(`Erreur HTTP ${response.status}`);
          }
          return response.text();
      })
   .then(text => JSON.parse(text))
   .then(data => {
          const listeLogements = document.getElementById('ListeLogements');

          // on liste les logements
          data.forEach(logement => {
              let tr = document.createElement('tr');
              tr.setAttribute('data-id', logement.id_logement)
              
              if (!logement.statut_propriete) {
                  tr.classList.add('offline');
              }
              
              let tdImage = document.createElement('td');
              let img = document.createElement('img');
              img.src = logement.image_principale;
              img.alt = logement.titre;
              tdImage.appendChild(img);

              let tdTitre = document.createElement('td');
              tdTitre.textContent = logement.titre;

              let tdAccroche = document.createElement('td');
              tdAccroche.textContent = logement.accroche;

              // Création du toggle pour le statut
              let tdStatut = document.createElement('td');
              let toggleId = 'toggle-' + logement.id_logement;
              let checkbox = document.createElement('input');
              checkbox.type = 'checkbox';
              checkbox.id = toggleId;
              checkbox.checked = logement.statut_propriete;
              checkbox.addEventListener('change', function() {
                  tr.classList.toggle('offline',!this.checked); 
                  updateLogementStatus(toggleId, this.checked); 
                  console.log(this.checked); 
              });
              
              let label = document.createElement('label');
              label.htmlFor = toggleId;
              label.textContent = 'Toggle';

              tdStatut.appendChild(checkbox);
              tdStatut.appendChild(label);

              let tdModifier = document.createElement('td');
              let icon = document.createElement('i');
              icon.className = 'fa-solid fa-pen';
              tdModifier.appendChild(icon);

              tr.appendChild(tdImage);
              tr.appendChild(tdTitre);
              tr.appendChild(tdAccroche);
              tr.appendChild(tdStatut);
              tr.appendChild(tdModifier);

              listeLogements.appendChild(tr);

            const redirectionDetails = document.querySelectorAll('td:not(:nth-child(4):not(:nth-child(5)))');

            const redirectionModifs = document.querySelectorAll('td:nth-child(5)');

            // Redirection vers la page de détails du logement
            redirectionDetails.forEach(element => {
                element.addEventListener('click', function(e) {
        
                    sessionStorage.setItem('idLogement', element.parentElement.getAttribute('data-id')); 

                    window.location.href = `/back/logements/details/`;
                });
            });

            // Redirection vers la page de modification du logement
            redirectionModifs.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const logementId = element.parentElement.getAttribute('data-id');
                    sessionStorage.setItem('logementId', logementId);
                    window.location.href = `/back/logements/details/modifier`;
                });
            });
            
          });
    })
   .catch(error => {
        console.error('Erreur lors de la récupération des logements:', error);
        alert('Erreur lors de la récupération des logements: ' + error.message);
    });
});

// Fonction pour mettre à jour le statut d'un logement

function updateLogementStatus(id, status) {
    let formdata = new FormData()
    formdata.append("logementId", id.split("-")[1]);
    formdata.append("status", status);

    fetch(`/api/updateLogementStatus`, {
        method: 'POST',
        body: formdata
    }).then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP ${response.status}`);
        }
        return response.json();
    });
}
