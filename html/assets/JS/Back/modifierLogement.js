import * as utils from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    const hiddenInput = document.getElementById('amenagements');
    let selectedAmenagements = [];

    let amenagementsBtns = document.querySelectorAll("#amenagementsBoutons button");

    function updateAmenagementsButtons() {
        amenagementsBtns.forEach(btn => {
            const id = btn.id;
            if (selectedAmenagements.includes(id)) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    amenagementsBtns.forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.stopPropagation(); // Empêcher la propagation de l'événement click vers le formulaire
            btn.classList.toggle("active");
            const id = this.id;
            const index = selectedAmenagements.indexOf(id);

            if (index > -1) {
                selectedAmenagements.splice(index, 1);
            } else {
                selectedAmenagements.push(id);
            }

            hiddenInput.value = JSON.stringify(selectedAmenagements);
        });
    });

    const dropZone = document.getElementById("drop-photo");
    const fileInput = document.getElementById("photo-input");
    const fileButton = document.getElementById("photo-button");

    dropZone.addEventListener("dragover", (event) => {
        event.preventDefault();
        dropZone.classList.add("dragover");
    });

    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("dragover");
    });

    dropZone.addEventListener("drop", (event) => {
        event.preventDefault();
        dropZone.classList.remove("dragover");
        console.log('drop file', event.dataTransfer.files);
        fileInput.files = event.dataTransfer.files;
        updatePhotoName(fileInput.files);
    });

    fileButton.addEventListener("click", () => {
        fileInput.click();
    });

    fileInput.addEventListener("change", (event) => {
        console.log('file change');
        const files = event.target.files;
        updatePhotoName(files);
    });

    function updatePhotoName(files) {
        const imagePreviewElement = document.getElementById('drop-photo');
        if (files.length > 0) {
            imagePreviewElement.style.backgroundImage = "url('" + URL.createObjectURL(files[0]) + "')";
        } else {
            imagePreviewElement.style.backgroundImage = "none";
        }
    }

    document.getElementById('formNewLogement').addEventListener('submit', function(event) {
        event.preventDefault();
        window.scroll({
            top: 0,
            behavior: 'smooth'
        });

        const formData = new FormData(this);
        formData.append('pays', 'France');
        formData.append('etat', '');

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            formData.append('photo', file);
        }

        const logementId = sessionStorage.getItem('logementId');
        if (logementId) {
            formData.append('id_logement', logementId);

            fetch('/api/processFormUpdateLogement', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        utils.ThrowAlertPopup(data.error, 'error');
                    } else {
                        let message = 'Le logement a bien été mis à jour!';
                        utils.ThrowAlertPopup(message, 'success');
                        localStorage.setItem('alertPopup', JSON.stringify({
                            message,
                            type: 'success'
                        }));
                        window.location.href = '/logements';
                    }
                })
                .catch(error => {
                    utils.ThrowAlertPopup('Erreur: ' + error, 'error');
                });
        } else {
            utils.ThrowAlertPopup('Erreur: ID du logement manquant.', 'error');
        }
    });

    function updateLogementInfo() {
        const logementId = sessionStorage.getItem('logementId');
        console.log(logementId)

        if (!logementId) {
            utils.ThrowAlertPopup('Erreur: ID du logement manquant.', 'error');
            return;
        }

        // Récupérer les données du logement
        fetch('/api/getLogementDataById/' + logementId)
            .then(response => response.json())
            .then(data => {
                // Remplir les champs du formulaire avec les données récupérées
                document.getElementById('titre').value = data[0]['titre'];
                document.getElementById('ville').value = data[0]['nom_ville'];
                document.getElementById('tarif').value = parseFloat(data[0]['prix_nuit_ttc']);
                document.getElementById('nom_rue').value = data[0]['nom_rue'];
                document.getElementById('cp').value = data[0]['code_postal'];
                document.getElementById('complement_adresse').value = data[0]['complement'];
                document.getElementById('accroche').textContent = data[0]['accroche'];
                document.getElementById('description').textContent = data[0]['description'];
                document.getElementById('surface').value = data[0]['surface_hab'];
                document.getElementById('nbPersMax').value = data[0]['personnes_max'];
                document.getElementById('nbChambres').value = data[0]['nb_chambres'];
                document.getElementById('nbLitsSimples').value = data[0]['nb_lits_simples'];
                document.getElementById('nbLitsDoubles').value = data[0]['nb_lits_doubles'];
                document.getElementById('delaiResaArrivee').value = data[0]['avance_resa_min'];
                document.getElementById('dureeMinLoc').value = data[0]['duree_min_location'];
                document.getElementById('delaiAnnulMax').value = data[0]['delai_annul_max'];

                // Affichage de l'image du logement
                let imageElement = document.getElementById('drop-photo');
                imageElement.style.backgroundImage = "url('" + data[0]['image_principale'] + "')";

                // Récupérer les aménagements actifs pour ce logement
                fetch('/api/getAmenagementsOfLogementById/' + logementId)
                    .then(response => response.json())
                    .then(dataAm => {
                        let idsAmenagementsActifs = dataAm.map(amenagement => amenagement.id_amenagement);

                        // Mettre à jour l'état des boutons d'aménagements
                        amenagementsBtns.forEach(btn => {
                            const id = btn.id;
                            if (idsAmenagementsActifs.includes(parseInt(id))) {
                                btn.classList.add('active');
                                if (!selectedAmenagements.includes(id)) {
                                    selectedAmenagements.push(id);
                                }
                            } else {
                                btn.classList.remove('active');
                                selectedAmenagements = selectedAmenagements.filter(a => a !== id);
                            }
                        });

                        // Mettre à jour la valeur de l'input caché avec les aménagements sélectionnés
                        hiddenInput.value = JSON.stringify(selectedAmenagements);
                    })
                    .catch(error => {
                        utils.ThrowAlertPopup('Erreur lors de la récupération des aménagements: ' + error, 'error');
                    });
            })
            .catch(error => {
                utils.ThrowAlertPopup('Erreur lors de la récupération des données du logement: ' + error, 'error');
            });
    }

    updateLogementInfo();
});
