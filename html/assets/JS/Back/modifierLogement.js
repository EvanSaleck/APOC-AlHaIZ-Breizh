import * as utils from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    const hiddenInput = document.getElementById('amenagements');
    let selectedAmenagements = [];

    // Vérifier s'il y a des aménagements déjà sélectionnés dans le champ caché
    if (hiddenInput.value) {
        selectedAmenagements = JSON.parse(hiddenInput.value);
    }

    let amenagementsBtns = document.querySelectorAll("#amenagementsBoutons button");

    // Fonction pour mettre à jour l'état des boutons d'aménagement
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

    // Mettre à jour les boutons d'aménagements au chargement
    updateAmenagementsButtons();

    // Gérer le clic sur les boutons d'aménagements
    amenagementsBtns.forEach(btn => {
        btn.addEventListener("click", function (e) {
            btn.classList.toggle("active");
            const id = this.id;
            const index = selectedAmenagements.indexOf(id);

            if (index > -1) {
                selectedAmenagements.splice(index, 1); // Désélectionner l'aménagement
            } else {
                selectedAmenagements.push(id); // Sélectionner l'aménagement
            }

            hiddenInput.value = JSON.stringify(selectedAmenagements); // Mettre à jour la valeur du champ caché
            console.log(selectedAmenagements); // Debug
        });
    });

    // Gestion du drag and drop et de l'upload de photo (non modifié)
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
    

    function updateLogementInfo() {
        let formData = JSON.parse(sessionStorage.getItem('formData'));

        // Affichage des données dans les champs du formulaire (non modifié)
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

        // Sélection des options pour les éléments select (type et catégorie) (non modifié)
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
        selectedAmenagements = formData.amenagements ? formData.amenagements.split(',') : [];
        updateAmenagementsButtons();

        // Affichage de l'image du logement si présente (non modifié)
        let imageElement = document.getElementById('drop-photo');
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

        formData.forEach((value, key) => {
            if (typeof value === 'string') {
                formData.set(key, encodeURIComponent(value));
            }
        });

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
            console.log(error)
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