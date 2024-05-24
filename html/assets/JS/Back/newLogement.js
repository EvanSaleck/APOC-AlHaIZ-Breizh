// dom chargé
document.addEventListener("DOMContentLoaded", function () {
  // resetErrors();

  const hiddenInput = document.getElementById('amenagements');
  let selectedAmenagements = [];
  let amenagementsBtns = document.querySelectorAll(
    "#amenagementsBoutons button"
  );

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
              ThrowAlertPopup(data['error'], "error");
            } else {
              ThrowAlertPopup("Le logement à bien été mis en ligne !", "succes");
              window.location.href = "/logements";
            }
          })
          .catch((error) => {
            console.log("Erreur: " + error);
            ThrowAlertPopup("Erreur: " + error, "error");
          });
      }
    });
});

function validateFormData(formData) {
  resetErrors();

  // on commence par tester le type de la photo ...
  if (!isValidImageType(formData.get('photo'))) {
    getNextErrorSpan('photo').textContent = 'Le fichier doit être une image de type jpeg, png, gif ou webp';
    document.querySelector('#photo').classList.add('error');
  }
  
  // puis on teste la taille de la photo
  if (!isValidImageSize(formData.get('photo'))) {
    getNextErrorSpan('photo').textContent = 'L\'image ne doit pas dépasser 200 Ko';
    document.querySelector('#photo').classList.add('error');
  }
  // on teste si une image a été sélectionnée
  if (formData.get('photo').size === 0) {
    getNextErrorSpan('photo').textContent = 'Veuillez sélectionner une image';
    document.querySelector('#photo').classList.add('error');
  }

  validateField(formData, 'titre', [
    { check: value => value.trim() !== '', errorMessage: 'Le titre ne peut pas être vide' },
    { check: value => /^[a-zA-Z0-9\s]*$/.test(value), errorMessage: 'Le titre ne peut pas contenir de caractères spéciaux' }
  ]);
  
  validateField(formData, 'tarif', [
    { check: value => value.trim() !== '', errorMessage: 'Le tarif ne peut pas être vide' },
    { check: value => value > 0, errorMessage: 'Le tarif doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le tarif doit être une valeur numérique' }
  ]);

  validateField(formData, 'nom_rue', [
    { check: value => value.trim() !== '', errorMessage: 'Le nom de rue ne peut pas être vide' },
    { check: value => /^[a-zA-Z0-9\s]*$/.test(value), errorMessage: 'Le nom de rue ne peut pas contenir de caractères spéciaux', condition: value => isNaN(value.split(' ')[0]) }
  ]);
  
  validateField(formData, 'ville', [
    { check: value => value.trim() !== '', errorMessage: 'La ville ne peut pas être vide' },
    { check: value => /^[a-zA-Z\s]*$/.test(value), errorMessage: 'La ville ne peut pas contenir de caractères spéciaux ni de caractères numériques' }
  ]);

  validateField(formData, 'cp', [
    { check: value => value.trim() !== '', errorMessage: 'Le code postal ne peut pas être vide' },
    { check: value => value.length === 5, errorMessage: 'Le code postal doit contenir 5 chiffres' },
    { check: value => !isNaN(value), errorMessage: 'Le code postal doit être une valeur numérique' }
  ]);

  validateField(formData, 'complement_adresse', [
    { check: value => /^[a-zA-Z0-9\s]*$/.test(value), errorMessage: 'Le complément d\'adresse ne peut pas contenir de caractères spéciaux' }
  ]);

  validateField(formData, 'pays', [
    { check: value => value.trim() !== '', errorMessage: 'Le pays ne peut pas être vide' },
    { check: value => /^[a-zA-Z\s]*$/.test(value), errorMessage: 'Le pays ne peut pas contenir de caractères spéciaux' }
  ]);

  validateField(formData, 'etat', [
    { check: value => /^[a-zA-Z0-9\s]*$/.test(value), errorMessage: 'L\'Etat ne peut pas contenir de caractère spéciaux' }
  ]);

  validateField(formData, 'surface', [
    { check: value => value.trim() !== '', errorMessage: 'La surface ne peut pas être vide' },
    { check: value => value > 0, errorMessage: 'La surface doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'La surface doit être une valeur numérique' }
  ]);

  validateField(formData, 'nbPersMax', [
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de personnes maximum ne peut pas être vide' },
    { check: value => value > 0, errorMessage: 'Le nombre de personnes maximum doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de personnes maximum doit être une valeur numérique' }
  ]);

  validateField(formData, 'nbChambres', [
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de chambres ne peut pas être vide' },
    { check: value => value > 0, errorMessage: 'Le nombre de chambres doit être supérieur à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de chambres doit être une valeur numérique' }
  ]);

  validateField(formData, 'nbLitsSimples', [
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de lits simples ne peut pas être vide' },
    { check: value => value >= 0, errorMessage: 'Le nombre de lits simples doit être supérieur ou égal à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de lits simples doit être une valeur numérique' }
  ]);

  validateField(formData, 'nbLitsDoubles', [
    { check: value => value.trim() !== '', errorMessage: 'Le nombre de lits doubles ne peut pas être vide' },
    { check: value => value >= 0, errorMessage: 'Le nombre de lits doubles doit être supérieur ou égal à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le nombre de lits doubles doit être une valeur numérique' }
  ]);

  validateField(formData, 'delaiResaArrivee', [
    { check: value => value >= 0, errorMessage: 'Le délai de réservation d\'arrivée doit être supérieur ou égal à 0' },
    { check: value => !isNaN(value), errorMessage: 'Le délai de réservation d\'arrivée doit être une valeur numérique' }
  ]);

  validateField(formData, 'dureeMinLoc', [
    { check: value => value >= 0, errorMessage: 'La durée minimale de location doit être supérieur ou égal à 0' },
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


function resetErrors(){
  // reinitialiser les divs erreurs
  document.querySelectorAll('.error').forEach((el) => {
    el.classList.remove('error');
  });
  // reinitialiser les messages d'erreur
  document.querySelectorAll('.messageError').forEach((el) => {
    el.textContent = '';
  });
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