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
  // Gestion du drag and drop et de l'upload de photo
  const dropZone = document.getElementById("drop-photo");
  const fileInput = document.getElementById("photo-input");
  const fileButton = document.getElementById("photo-button");

  // Ajoute la classe "dragover" lorsque l'utilisateur fait glisser un fichier sur la zone de drop
  dropZone.addEventListener("dragover", (event) => {
      event.preventDefault();
      dropZone.classList.add("dragover");
  });

  // Supprime la classe "dragover" lorsque l'utilisateur quitte la zone de drop
  dropZone.addEventListener("dragleave", () => {
      dropZone.classList.remove("dragover");
  });

  // Gère le dépôt de fichier
  dropZone.addEventListener("drop", (event) => {
      event.preventDefault();
      dropZone.classList.remove("dragover");
      console.log('drop file', event.dataTransfer.files);
      fileInput.files = event.dataTransfer.files;
      updatePhotoName(fileInput.files);
  });

  // Ouvre le sélecteur de fichiers lorsque l'utilisateur clique sur le bouton
  fileButton.addEventListener("click", () => {
      fileInput.click();
  });

  // Gère la sélection de fichier via le sélecteur de fichiers
  fileInput.addEventListener("change", (event) => {
      console.log('file change');
      const files = event.target.files;
      updatePhotoName(files);
  });

  // Fonction pour mettre à jour le nom de l'image sélectionnée
  function updatePhotoName(files) {
      document.querySelector('#photo-nom-image').textContent = files.length > 0 ? files[0].name : '';
  }

  function updateLogementInfo() {
    let formData = JSON.parse(sessionStorage.getItem('formData'));

    // Affichage des données dans les champs du formulaire
    Object.keys(formData).forEach(key => {
        let element = document.getElementById(key);
        if (element) {
            if (key === 'description' || key === 'accroche') {
                element.textContent = formData[key];
            } else if (key === 'image') {
                let imageElement = document.getElementById('image-logement');
                if (imageElement) {
                    imageElement.style.backgroundImage = "url('" + formData[key] + "')";
                }
            } else {
                element.value = formData[key];
            }
        }
    });

    // Sélection des options pour les éléments select (type et catégorie)
    ['type', 'categorie'].forEach(selectId => {
        let select = document.getElementById(selectId);
        if (select && formData[selectId]) {
            let selectedIndex = Array.from(select.options).findIndex(option => option.value === formData[selectId]);
            if (selectedIndex !== -1) {
                select.selectedIndex = selectedIndex;
            }
        }
    });

    // Gestion des boutons d'aménagements
    let selectedAmenagements = formData.amenagements.split(',');
    let amenagementsBtns = document.querySelectorAll("#amenagementsBoutons button");
    amenagementsBtns.forEach(btn => {
        if (selectedAmenagements.includes(btn.id)) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // Affichage de l'image du logement si présente
    let imageElement = document.getElementById('image-logement');
    if (imageElement && formData.image) {
        imageElement.style.backgroundImage = "url('" + formData.image + "')";
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

    // Ajout de l'image sélectionnée s'il y en a une
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        formData.append('photo', file);
    }

    // Fonction pour mettre à jour le logement
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
