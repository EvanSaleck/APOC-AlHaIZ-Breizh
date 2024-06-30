import * as utils from '../utils.js';

// dom chargé
document.addEventListener("DOMContentLoaded", function () {
  // resetErrors();

  const hiddenInput = document.getElementById('amenagements');
  let selectedAmenagements = [];
  let amenagementsBtns = document.querySelectorAll(
    "#amenagementsBoutons button"
  );

  // on met à jour les boutons d'aménagement
  amenagementsBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      btn.classList.toggle("active");
      const id = this.id;
      const index = selectedAmenagements.indexOf(id);

      // Ajouter ou supprimer l'ID dans selectedAmenagements
      if (index > -1) {
        // ID déjà présent, le retirer
        selectedAmenagements.splice(index, 1);
        this.classList.remove("selected"); // Ajouter une classe pour indiquer la sélection
      } else {
        // ID non présent, l'ajouter
        selectedAmenagements.push(id);
        this.classList.add("selected"); // Ajouter une classe pour indiquer la sélection
      }

      // Mettre à jour le champ caché
      hiddenInput.value = JSON.stringify(selectedAmenagements);
    });
  });


  document
    .getElementById("formNewLogement")
    .addEventListener("submit", function (event) {
      
      event.preventDefault(); // Empêche la soumission par défaut du formulaire
      window.scroll({
        top: 0,
        behavior: 'smooth'
      });
      // Crée un nouvel objet FormData à partir du formulaire
      var formData = new FormData(this);

      formData.append('pays','France');
      formData.append('etat','');

      
      const fileInput = document.getElementById("photo-input");
      if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        formData.append("photo", file);
      }
        
      // on envoie le formulaire en le traitant si il est valide
      if (validateFormData(formData)) {
        fetch("/api/processFormNewLogement", {
          method: "POST",
          body: formData,
        })
          .then((response) => {
            return response.json();
          })
          .then((data) => {
            console.log(data['error']);
            if(data['error']){
              utils.ThrowAlertPopup(data['error'], "error");
            } else {
              let message = "Le logement à bien été mis en ligne !";
              utils.ThrowAlertPopup(message, "success");
              localStorage.setItem('alertPopup', JSON.stringify({ message: message, type: 'success' }));
              window.location.href = "/logements";
            }
          })
          .catch((error) => {
            console.log("Erreur: " + error);
            utils.ThrowAlertPopup("Erreur: " + error, "error");
          });
      }
    });

    // Gestion du drag and drop pour l'upload de la photo
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
  
      // Use DataTransfer to assign files
      const dataTransfer = new DataTransfer();
      for (let i = 0; i < event.dataTransfer.files.length; i++) {
          dataTransfer.items.add(event.dataTransfer.files[i]);
      }
      fileInput.files = dataTransfer.files;
  
      // Déclenche manuellement l'événement 'change'
      const changeEvent = new Event('change');
      fileInput.dispatchEvent(changeEvent);
    });
  

    // Ouvre le sélecteur de fichiers lorsque l'utilisateur clique sur le bouton
    fileButton.addEventListener("click", () => {
        fileInput.click();
    });

    // Gère la sélection de fichier via le sélecteur de fichiers
    fileInput.addEventListener("change", (event) => {
      console.log('file change');
      const files = event.target.files;
  
      utils.resetErrors(); 
      if (verifPhoto(files)) {
          const file = files[0];
          console.log(fileInput.files);
  
          // Use DataTransfer to assign the file
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          fileInput.files = dataTransfer.files;
      }
    });
});

// Fonction pour valider les données du formulaire
function validateFormData(formData) {
  // on remet a zero les erreurs
  utils.resetErrors();

  // Vérification de la photo
  verifPhoto([formData.get('photo')]);

  validateField(formData, 'titre', [
    { check: value => value.trim() !== '', errorMessage: 'Le titre ne peut pas être vide' },
    // on ajoute la possibilité de mettre des -
    { check: value => /^[a-zA-Z0-9\s\-]*$/.test(value), errorMessage: 'Le titre ne peut pas contenir de caractères spéciaux' }
  ]);
  
  validateField(formData, 'tarif', [
    { check: value => value > 0, errorMessage: 'Le tarif doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le tarif doit être une valeur numérique' },
    { check: value => value.trim() !== '', errorMessage: 'Le tarif ne peut pas être vide' }
  ]);

  validateField(formData, 'nom_rue', [
    { check: value => value.trim() !== '', errorMessage: 'Le nom de rue ne peut pas être vide' },
    { check: value => /^[a-zA-Z0-9\s\-]*$/.test(value), errorMessage: 'Le nom de rue ne peut pas contenir de caractères spéciaux', condition: value => isNaN(value.split(' ')[0]) }
  ]);
  
  validateField(formData, 'ville', [
    { check: value => value.trim() !== '', errorMessage: 'La ville ne peut pas être vide' },
    { check: value => /^[a-zA-Z\s\-\'éèêëïîöôùûüàç]*$/.test(value), errorMessage: 'La ville ne peut pas contenir de caractères spéciaux' }
  ]);

  validateField(formData, 'cp', [
    { check: value => value.startsWith('29') || value.startsWith('22') || value.startsWith('35') || value.startsWith('56'), errorMessage: 'Le code postal doit être en Bretagne' },
    { check: value => value.length === 5, errorMessage: 'Le code postal doit contenir 5 chiffres' },
    { check: value => !isNaN(value), errorMessage: 'Le code postal doit être une valeur numérique' },
    { check: value => value.trim() !== '', errorMessage: 'Le code postal ne peut pas être vide' }
  ]);

  validateField(formData, 'complement_adresse', [
    { check: value => /^[a-zA-Z0-9\s\-\'éèêëïîöôùûüàç]*$/.test(value), errorMessage: 'Le complément d\'adresse ne peut pas contenir de caractères spéciaux autres que les tirets, apostrophes, et accents' }
  ]);

  validateField(formData, 'surface', [
    { check: value => value > 0, errorMessage: 'La surface doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'La surface doit être une valeur numérique' },
    { check: value => value.trim() !== '', errorMessage: 'La surface ne peut pas être vide' }
  ]);

  validateField(formData, 'nbPersMax', [
    { check: value => value > 0, errorMessage: 'Le nombre de personnes maximum doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de personnes maximum doit être une valeur numérique' },
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de personnes maximum ne peut pas être vide' }
  ]);

  validateField(formData, 'nbChambres', [
    { check: value => value > 0, errorMessage: 'Le nombre de chambres doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de chambres doit être une valeur numérique' },
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de chambres ne peut pas être vide' }
  ]);

  validateField(formData, 'nbLitsSimples', [
    { check: value => value >= 0, errorMessage: 'Le nombre de lits simples doit être supérieur ou égal à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de lits simples doit être une valeur numérique' },
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de lits simples ne peut pas être vide' }
  ]);

  validateField(formData, 'nbLitsDoubles', [
    { check: value => value >= 0, errorMessage: 'Le nombre de lits doubles doit être supérieur ou égal à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de lits doubles doit être une valeur numérique' },
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de lits doubles ne peut pas être vide' }
  ]);

  validateField(formData, 'delaiResaArrivee', [
    { check: value => value >= 0, errorMessage: 'Le délai de réservation d\'arrivée doit être supérieur ou égal à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le délai de réservation d\'arrivée doit être une valeur numérique' }
  ]);

  validateField(formData, 'dureeMinLoc', [
    { check: value => value >= 2, errorMessage: 'La durée minimale de location doit être supérieur ou égal à 2' },
    { check: value => !isNaN(value), errorMessage: 'La durée minimale de location doit être une valeur numérique' }
  ]);

  validateField(formData, 'delaiAnnulMax', [
    { check: value => value >= 0, errorMessage: 'Le délai d\'annulation maximal doit être supérieur ou égal à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le délai d\'annulation maximal doit être une valeur numérique' }
  ]);

  return document.querySelectorAll('.error').length === 0;
}

function validateField(formData, fieldName, validations) {
  const field = formData.get(fieldName);
  validations.forEach(validation => {
    if ((typeof validation.condition === 'undefined' || validation.condition(field)) && !validation.check(field)) {
      const errorSpan = getNextErrorSpan(fieldName);
      errorSpan.textContent = validation.errorMessage;
      document.querySelector(`#${fieldName}`).classList.add('error');
    }
  });
}

// fonciton permettant de récupérer le prochain élément avec la classe 'messageError'
function getNextErrorSpan(id) {
  // Trouver l'élément initial à partir de son ID
  var initialElement = document.getElementById(id);

  if (!initialElement) {
      console.error('L\'élément avec l\'ID spécifié n\'existe pas.');
      return null;
  }

  // Fonction pour parcourir les descendants
  function findInDescendants(element) {
      var descendants = element.querySelectorAll('.messageError');
      if (descendants.length > 0) {
          return descendants[0];
      }
      return null;
  }

  // Chercher parmi les frères et sœurs de l'élément initial
  var siblings = Array.from(initialElement.parentNode.children);
  var index = siblings.indexOf(initialElement);

  for (let i = index + 1; i < siblings.length; i++) {
      if (siblings[i].classList.contains('messageError')) {
          return siblings[i];
      }
      let descendant = findInDescendants(siblings[i]);
      if (descendant) {
          return descendant;
      }
  }

  // Fonction pour parcourir les ancêtres
  function findInAncestors(element) {
      var current = element.parentNode;
      while (current && current !== document.body) {
          if (current.classList.contains('messageError')) {
              return current;
          }
          let sibling = getNextSiblingWithMessageError(current);
          if (sibling) {
              return sibling;
          }
          current = current.parentNode;
      }
      return null;
  }

  // Fonction pour trouver le prochain frère ou descendant avec la classe 'messageError'
  function getNextSiblingWithMessageError(element) {
      let sibling = element.nextElementSibling;
      while (sibling) {
          if (sibling.classList.contains('messageError')) {
              return sibling;
          }
          let descendant = findInDescendants(sibling);
          if (descendant) {
              return descendant;
          }
          sibling = sibling.nextElementSibling;
      }
      return null;
  }

  // Chercher parmi les descendants de l'élément initial
  let descendant = findInDescendants(initialElement);
  if (descendant) {
      return descendant;
  }

  // Chercher parmi les ancêtres et leurs prochains frères et sœurs
  return findInAncestors(initialElement);
}


// a mettre dans le function.js à un moment donné
function isValidImageType(file) {
  // Types d'images valides
  var validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

  // Vérifier si le type du fichier est une image valide
  return validImageTypes.includes(file.type);
}

// a mettre dans le function.js à un moment donné
function isValidImageSize(file) {
  // Taille maximale (200 Ko)
  var maxSize = 200000;

  // Vérifier si la taille du fichier est inférieure à la taille maximale
  return file.size <= maxSize;
}

function verifPhoto(files) {
  // on remet a zero les erreurs
  document.querySelector('#photo-input').classList.remove('error');
  getNextErrorSpan('photo-input').textContent = '';

  // on affiche une erreur si il y a plus d'un fichier
  if (files.length > 1) {
      getNextErrorSpan('photo-input').textContent = 'Veuillez sélectionner une seule image';
      document.querySelector('#photo-input').classList.add('error');
      return false;
  }

  // on affiche une erreur si il n'y a pas de fichier
  if (files.length === 0) {
      getNextErrorSpan('photo-input').textContent = 'Veuillez sélectionner une image';
      document.querySelector('#photo-input').classList.add('error');
      return false;
  }

  var file = files[0];
  if (file){
    document.querySelector('#photo-nom-image').textContent = file.name;
  }

  if (file && !isValidImageType(file)) {
      getNextErrorSpan('photo-input').textContent = 'Le fichier doit être une image de type jpeg, png, gif ou webp';
      document.querySelector('#photo-input').classList.add('error');
  }

  if (file && !isValidImageSize(file)) {
      getNextErrorSpan('photo-input').textContent = 'L\'image ne doit pas dépasser 200 Ko';
      document.querySelector('#photo-input').classList.add('error');
  }

  if (!file || file.size === 0) {
      getNextErrorSpan('photo-input').textContent = 'Veuillez sélectionner une image';
      document.querySelector('#photo-input').classList.add('error');
  }

  // on retourne si il y a une erreur
  return document.querySelectorAll('.error').length === 0;
}