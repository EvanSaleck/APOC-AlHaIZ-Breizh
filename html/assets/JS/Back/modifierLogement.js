import * as utils from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
  const hiddenInput = document.getElementById('amenagements');
  let selectedAmenagements = [];
  let amenagementsBtns = document.querySelectorAll("#amenagementsBoutons button");

  amenagementsBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      btn.classList.toggle("active");
      const id = this.id;
      const index = selectedAmenagements.indexOf(id);

      if (index > -1) {
        selectedAmenagements.splice(index, 1);
        this.classList.remove("selected");
      } else {
        selectedAmenagements.push(id);
        this.classList.add("selected");
      }

      hiddenInput.value = JSON.stringify(selectedAmenagements);

      
    });
  });

  function updateLogementInfo() {
    let conteneur = document.querySelector('.infosReservationDev');
    let data = JSON.parse(sessionStorage.getItem('formData'));

    const elements = {
      titre: data.titre,
      tarif: data.tarif,
      nom_rue: data.nom_rue,
      ville: data.ville,
      cp: data.cp,
      description: data.description,
      nbChambres: data.nbChambres,
      nbLitsSimples: data.nbLitsSimples,
      nbLitsDoubles: data.nbLitsDoubles,
      nbPersMax: data.nbPersMax,
      surface: data.surface,
      categorie: data.categorie,
      type: data.type,
      delaiAnnulMax: data.delaiAnnulMax,
      delaiResaArrivee: data.delaiResaArrivee,
      dureeMinLoc: data.dureeMinLoc,
      accroche: data.accroche,
      amenagements: data.amenagements
    };

    for (let key in elements) {
      let element = document.getElementById(key);
      if (element) {
        if (key === 'description' || key === 'accroche') {
          element.textContent = elements[key];
        } else {
          element.value = elements[key];
        }
      }
    }

    if (data.type) {
      let select = document.getElementById('type');
      let options = select.options;
      for (let i = 0; i < options.length; i++) {
        if (options[i].value === data.type) {
          select.selectedIndex = i;
          break;
        }
      }
    }

    if (data.categorie) {
      let select = document.getElementById('categorie');
      let options = select.options;
      for (let i = 0; i < options.length; i++) {
        if (options[i].value === data.categorie) {
          select.selectedIndex = i;
          break;
        }
      }
    }
  }

  updateLogementInfo();

  document.getElementById('formNewLogement').addEventListener('submit', function (event) {
    event.preventDefault();

    window.scroll({
        top: 0,
        behavior: 'smooth'
    });

    const formData = new FormData(this);
    formData.append('pays', 'France');
    formData.append('etat', '');

    // Utilisation de encodeURIComponent pour les valeurs de texte
    formData.forEach((value, key) => {
        if (typeof value === 'string') {
            formData.set(key, encodeURIComponent(value));
        }
    });

    const fileInput = document.getElementById('photo-input');
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        formData.append('photo', file);
    }

    function updateLogement(logementId) {
        formData.append('id_logement', logementId);

        fetch('/api/processFormUpdateLogement', {
            method: 'POST',
            body: formData,
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                utils.ThrowAlertPopup(data.error, 'error');
            } else {
                let message = 'Le logement a bien été mis à jour !';
                utils.ThrowAlertPopup(message, 'success');
                localStorage.setItem('alertPopup', JSON.stringify({ message: message, type: 'success' }));
                window.location.href = '/logements';
            }
        })
        .catch((error) => {
            utils.ThrowAlertPopup('Erreur: ' + error, 'error');
        });
    }

    const logementId = sessionStorage.getItem('logementId');
    if (logementId) {
        updateLogement(logementId);
    } else {
        utils.ThrowAlertPopup('Erreur: ID du logement manquant.', 'error');
    }
});

});
