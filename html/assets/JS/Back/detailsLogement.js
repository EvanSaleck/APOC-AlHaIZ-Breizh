var inputs = document.getElementsByTagName('input');
// Désactivation des champs input
for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].id !== 'btnModifier') {
        inputs[i].disabled = true;
    }
}

// Désactivation des champs select
var selects = document.getElementsByTagName('select');
for (var i = 0; i < selects.length; i++) {
    selects[i].disabled = true;
}

// Désactivation des zones de texte
var textArea = document.getElementsByTagName('textarea');
for (var i = 0; i < textArea.length; i++) {
    textArea[i].disabled = true;
}

function envoyerInfos() {
    var formData = {};
    // Traitement des champs input
    for (var i = 0; i < inputs.length; i++) {
        formData[inputs[i].name] = inputs[i].value;
    }

    // Traitement des champs select
    for (var i = 0; i < selects.length; i++) {
        formData[selects[i].name] = selects[i].value;
    }

    // Traitement des zones de texte
    for (var i = 0; i < textArea.length; i++) {
        formData[textArea[i].name] = textArea[i].value;
    }

    // Inclusion de l'image du logement si disponible
    var imageElement = document.getElementById('image-logement');
    if (imageElement) {
        formData['image'] = imageElement.style.backgroundImage.replace(/url\(['"]?(.*?)['"]?\)/, '$1');
    }


    // Traitement des boutons spécifiques pour récupérer leurs informations
    var boutons = document.querySelectorAll('#amenagementsBoutons button');
    var selectedAmenagements = [];
    for (var i = 0; i < boutons.length; i++) {
        if (boutons[i].classList.contains('active')) {
            selectedAmenagements.push(boutons[i].id);
        }
    }

    formData['amenagements'] = selectedAmenagements.join(',');

    // Enregistrement dans sessionStorage
    sessionStorage.setItem('formData', JSON.stringify(formData));
}

document.addEventListener('DOMContentLoaded', function() {
    //  Récupération des données du logement
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        data.forEach(logement => {

            let logementId = data[0]['id_logement']; // Récupérer l'ID du logement
            sessionStorage.setItem('logementId', logementId); // Stocker l'ID du logement dans sessionStorage

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

            const redirectionModifs = document.querySelectorAll('.btnModifier');
            redirectionModifs.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    envoyerInfos();
                    window.location.href = '/back/logements/details/modifier';
                });
            });

            // Récupération des catégories du logement
            fetch('/api/getCategorieOfLogementById/' + sessionStorage.getItem('idLogement'))
            .then(response => response.json())
            .then(dataCategorie => {
                let categorie = document.getElementById("categorie");
                let selectedIndex = -1;
                for (let i = 0; i < categorie.options.length; i++) {
                    if (categorie.options[i].text === dataCategorie[0]['nom_categorie'].charAt(0).toUpperCase() + dataCategorie[0]['nom_categorie'].slice(1)) {
                        selectedIndex = i;
                        break;
                    }
                }
                if (selectedIndex !== -1) {
                    categorie.selectedIndex = selectedIndex;
                } else {
                    console.warn('Option pour la catégorie reçue non trouvée.');
                }
            });

            // Récupération des types du logement
            fetch('/api/getTypeOfLogementById/' + sessionStorage.getItem('idLogement'))
            .then(response => response.json())
            .then(dataType => {
                let type = document.getElementById("type");
                let selectedIndex = -1;
                for (let i = 0; i < type.options.length; i++) {
                    if (type.options[i].text === dataType[0]['nom_type']) {
                        selectedIndex = i;
                        break;
                    }
                }
                if (selectedIndex !== -1) {
                    type.selectedIndex = selectedIndex;
                } else {
                    console.warn('Option pour le type reçu non trouvée.');
                }
            });

            // Récupération des amengements du logement
            let boutonsAmenagements = document.getElementById("amenagementsBoutons");
            fetch('/api/getAmenagementsOfLogementById/' + sessionStorage.getItem('idLogement'))
            .then(response => response.json())
            .then(dataAm => {
                let idsAmenagementsActifs = dataAm.map(amenagement => amenagement.id_amenagement);

                for (let bouton of boutonsAmenagements.getElementsByTagName('button')) {
                    if (idsAmenagementsActifs.includes(parseInt(bouton.id))) {
                        bouton.classList.add('active');
                    } else {
                        bouton.classList.remove('active');
                    }
                }
            })
            .catch(error => console.error('Erreur lors de la récupération des données:', error));
        });
    });
});
