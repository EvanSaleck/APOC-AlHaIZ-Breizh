document.addEventListener('DOMContentLoaded', function() {


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
  
    function updateLogementInfo() {
        let conteneur = document.querySelector('.infosReservationDev');
    
        let data = JSON.parse(sessionStorage.getItem('formData'));
        console.log(data);

        const titreLogement = data.titre;
        const tarif = data.tarif;
        const nom_rue = data.nom_rue;
        const ville = data.ville;
        const cp = data.cp;
        const description = data.description;
        const nbChambres = data.nbChambres;
        const nbLitsSimples = data.nbLitsSimples;
        const nbLitsDoubles = data.nbLitsDoubles;
        const nbPersMax = data.nbPersMax;
        const surface = data.surface;
        const categorie = data.categorie;
        const type = data.type;
        const delaiAnnulMax = data.delaiAnnulMax;
        const delaiResaArrivee = data.delaiResaArrivee;
        const dureeMinLoc = data.dureeMinLoc;
        const accroche = data.accroche;
        const amenagements = data.amenagements;
    
         let titreLogementElement = document.getElementById('titre');
        let tarifElement = document.getElementById('tarif');
        let nomRueElement = document.getElementById('nom_rue');
        let villeElement = document.getElementById('ville');
        let cpElement = document.getElementById('cp'); 
        let descriptionElement = document.getElementById('description');
        let nbChambresElement = document.getElementById('nbChambres');
        let nbLitsSimplesElement = document.getElementById('nbLitsSimples');
        let nbLitsDoublesElement = document.getElementById('nbLitsDoubles');
        let nbPersMaxElement = document.getElementById('nbPersMax');
        let surfaceElement = document.getElementById('surface');
        let categorieElement = document.getElementById('categorie');
        let typeElement = document.getElementById('type');
        let delaiAnnulMaxElement = document.getElementById('delaiAnnulMax');
        let delaiResaArriveeElement = document.getElementById('delaiResaArrivee');
        let dureeMinLocElement = document.getElementById('dureeMinLoc');
        let accrocheElement = document.getElementById('accroche');
        let amenagementsElement = document.getElementById('amenagements');
        
    
        titreLogementElement.value = titreLogement;
        tarifElement.value = tarif;
        nomRueElement.value = nom_rue;
        villeElement.value = ville;
        cpElement.value = cp; 
        descriptionElement.textContent = description;
        nbChambresElement.value = nbChambres;
        nbLitsSimplesElement.value = nbLitsSimples;
        nbLitsDoublesElement.value = nbLitsDoubles;
        nbPersMaxElement.value = nbPersMax;
        surfaceElement.value = surface;
        dureeMinLocElement.value = dureeMinLoc;
        delaiAnnulMaxElement.value = delaiAnnulMax;
        delaiResaArriveeElement.value = delaiResaArrivee;
        accrocheElement.textContent = accroche; 

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
        if (data.amenagements) {
            let select = document.getElementById('amenagements');
            let options = select.options;

            for (let i = 0; i < options.length; i++) {
                if (options[i].value === data.amenagements) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }
        delaiAnnulMaxElement.value = delaiAnnulMax;
        delaiResaArriveeElement.value = delaiResaArrivee;
        dureeMinLocElement.value = dureeMinLoc;
    }
    
    updateLogementInfo();
    
});
