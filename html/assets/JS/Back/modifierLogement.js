/*var inputs = document.getElementsByTagName('input');
for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].id!== 'btnModifier') {
        inputs[i].disabled = true;
    }
}

var selects = document.getElementsByTagName('select');
for (var i = 0; i < selects.length; i++) {
    selects[i].disabled = true;
}


var textArea = document.getElementsByTagName('textarea');
for (var i = 0; i < textArea.length; i++) {
    textArea[i].disabled = true;
}*/

console.log('detailsLogement.js');
document.addEventListener('DOMContentLoaded', function() {
    console.log(sessionStorage.getItem('idLogement'));
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        console.log(data) 

        let titreLogement = document.getElementById("titre");
        titreLogement.value = data[0]['titre'];

        let villeLogement = document.getElementById("ville");
        villeLogement.value = data[0]['nom_ville'];

        let prixLogement = document.getElementById("tarif");
        prixLogement.value = parseFloat(data[0]['prix_nuit_ttc']);

        let nom_rue = document.getElementById("nom_rue");
        nom_rue.value = data[0]['nom_rue'];

        let ville = document.getElementById("ville");
        ville.value = data[0]['nom_ville'];

        let cp = document.getElementById("cp");
        cp.value = data[0]['code_postal'];

        let complement = document.getElementById("complement_adresse");
        complement.value = data[0]['complement'];

        let accroche = document.getElementById("accroche");
        accroche.textContent = data[0]['accroche'];

        let descDet = document.getElementById("description");
        descDet.textContent = data[0]['description'];
        
        let surface_hab = document.getElementById("surface");
        surface_hab.value = data[0]['surface_hab'];

        let personnes_max = document.getElementById("nbPersMax");
        personnes_max.value = data[0]['personnes_max'];


        let nombreChambres = document.getElementById("nbChambres");
        nombreChambres.value = data[0]['nb_chambres'];

        let nombreLitsSimples = document.getElementById("nbLitsSimples");
        nombreLitsSimples.value = data[0]['nb_lits_simples'];

        let nombreLitsDoubles = document.getElementById("nbLitsDoubles");
        nombreLitsDoubles.value = data[0]['nb_lits_doubles'];

        let delaiResaArrivee = document.getElementById("delaiResaArrivee");
        delaiResaArrivee.value = data[0]['avance_resa_min'];

        let dureeMinLocation = document.getElementById("dureeMinLoc");
        dureeMinLocation.value = data[0]['duree_min_location'];

        let delaiAnnulMax = document.getElementById("delaiAnnulMax");
        delaiAnnulMax.value = data[0]['delai_annul_max'];
        
        let image = document.getElementById("image-logement");
        image.style.backgroundImage = "url('" + data[0]['image_principale'] + "')";

        
        
        
        

        

            
assets/JS/Back/detailsLogement.js
        

        const boutonModifier = document.querySelectorAll('.btnModifier > input');
        
            boutonModifier.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                
                    sessionStorage.setItem('idLogement', this.parentElement.getAttribute('data-id'));
                
                    // Redirige en utilisant window.location
                    window.location = "/logements/details/modifier";
                });
                
            });
    });
    fetch('/api/getCategorieOfLogementById/' + sessionStorage.getItem('idLogement'))
   .then(response => response.json())
   .then(dataCategorie => {
        console.log(dataCategorie);
        let categorie = document.getElementById("categorie");
        console.log(categorie)
        
        // Trouver l'index de l'option correspondant à la catégorie reçue
        let selectedIndex = -1;
        for(let i = 0; i < categorie.options.length; i++) {
            if(categorie.options[i].text === dataCategorie[0]['nom_categorie']) {
                selectedIndex = i;
                break;
            }
        }

        // Vérifier si l'index a été trouvé
        if(selectedIndex!== -1) {
            categorie.selectedIndex = selectedIndex;
        } else {
            console.warn('Option pour la catégorie reçue non trouvée.');
        }
    });

fetch('/api/getTypeOfLogementById/' + sessionStorage.getItem('idLogement'))
   .then(response => response.json())
   .then(dataType => {
        console.log(dataType);
        let type = document.getElementById("type");
        console.log(type)
        
        // Trouver l'index de l'option correspondant au type reçu
        let selectedIndex = -1;
        for(let i = 0; i < type.options.length; i++) {
            if(type.options[i].text === dataType[0]['nom_type']) {
                selectedIndex = i;
                break;
            }
        }

        // Vérifier si l'index a été trouvé
        if(selectedIndex!== -1) {
            type.selectedIndex = selectedIndex;
        } else {
            console.warn('Option pour le type reçu non trouvée.');
        }
    });

});