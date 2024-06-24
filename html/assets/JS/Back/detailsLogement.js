var inputs = document.getElementsByTagName('input');
for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].id !== 'btnModifier') {
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

    // Inclusion de l'image du logement
    var imageElement = document.querySelector('#image-logement');
    if (imageElement) {
        formData['image'] = imageElement.src;
    }

    // Traitement des boutons spécifiques pour récupérer leurs informations
    var boutons = document.querySelectorAll('#amenagementsBoutons button');
    var selectedAmenagements = [];
    for (var i = 0; i < boutons.length; i++) {
        if (selectedAmenagements.indexOf(boutons[i].id) === -1) {
            selectedAmenagements.push(boutons[i].id);
            boutons[i].classList.add('active');
        } else {
            boutons[i].classList.remove('active');
        }
    }

    formData['amenagements'] = selectedAmenagements.join(',');

    console.log(formData);
    sessionStorage.setItem('formData', JSON.stringify(formData));
}

console.log('detailsLogement.js');
document.addEventListener('DOMContentLoaded', function() {
    console.log(sessionStorage.getItem('idLogement'));
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        data.forEach(logement => {
            console.log(data)

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
            console.log(data[0]['id_logement'])

            const redirectionModifs = document.querySelectorAll('.btnModifier');
            redirectionModifs.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    envoyerInfos();
                    window.location.href = '/logements/details/modifier';
                });
            });

            fetch('/api/getCategorieOfLogementById/' + sessionStorage.getItem('idLogement'))
            .then(response => response.json())
            .then(dataCategorie => {
                console.log(dataCategorie);
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

            fetch('/api/getTypeOfLogementById/' + sessionStorage.getItem('idLogement'))
            .then(response => response.json())
            .then(dataType => {
                console.log(dataType);
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

            let boutonsAmenagements = document.getElementById("amenagementsBoutons");
            fetch('/api/getAmenagementsOfLogementById/' + sessionStorage.getItem('idLogement'))
            .then(response => response.json())
            .then(dataAm => {
                console.log(dataAm);
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
