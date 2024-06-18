import { ThrowAlertPopup } from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    const storedPopup = localStorage.getItem('alertPopup');
    let message, type;

    try {
        if (storedPopup) {
            ({ message, type } = JSON.parse(storedPopup));
            ThrowAlertPopup(message, type);
        }
    } catch (error) {
        console.error('Données de popup stockées invalides:', error);
    }

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

          data.forEach(logement => {
              let tr = document.createElement('tr');
              
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

              let tdStatut = document.createElement('td');
              let toggleId = 'toggle-' + logement.id_logement;
              let checkbox = document.createElement('input');
              checkbox.type = 'checkbox';
              checkbox.id = toggleId;
              checkbox.checked = logement.statut_propriete;
              checkbox.addEventListener('change', function() {
                  tr.classList.toggle('offline',!this.checked); // Change la classe CSS en fonction de l'état de la case à cocher
                  updateLogementStatus(toggleId, this.checked); // Met à jour le statut sur le serveur
                  console.log(this.checked); // Log l'état actuel de la case à cocher
              });
              
              let label = document.createElement('label');
              label.htmlFor = toggleId;
              label.textContent = 'Toggle';

              tdStatut.appendChild(checkbox);
              tdStatut.appendChild(label);

              let tdModifier = document.createElement('td');
              let icon = document.createElement('i');
              icon.className = 'fa-solid fa-pen';
              icon.onclick = () => window.location.href = `/logement/edit/${logement.id_logement}`;
              tdModifier.appendChild(icon);

              tr.appendChild(tdImage);
              tr.appendChild(tdTitre);
              tr.appendChild(tdAccroche);
              tr.appendChild(tdStatut);
              tr.appendChild(tdModifier);

              listeLogements.appendChild(tr);
          });
    })
   .catch(error => {
        console.error('Erreur lors de la récupération des logements:', error);
        alert('Erreur lors de la récupération des logements: ' + error.message);
    });
});

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
