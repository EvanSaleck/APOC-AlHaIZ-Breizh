import * as utils from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    const hiddenInput = document.getElementById('amenagements');
    let selectedAmenagements = [];

    if (hiddenInput.value) {
        selectedAmenagements = JSON.parse(hiddenInput.value);
    }

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
            e.stopPropagation(); // Ajouté pour empêcher la propagation de l'événement click vers le formulaire
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

    function getAddressFormData() {
        return {
            nom_rue: document.getElementById('nom_rue').value.trim(),
            ville: document.getElementById('ville').value.trim(),
            cp: document.getElementById('cp').value.trim(),
            complement_adresse: document.getElementById('complement_adresse').value.trim()
        };
    }

    document.getElementById('formNewLogement').addEventListener('submit', function(event) {
        event.preventDefault();
        window.scroll({
            top: 0,
            behavior: 'smooth'
        });

        const formData = new FormData(this);
        formData.append('pays','France');
        formData.append('etat','');
        formData.forEach((value, key) => {
            if (typeof value === 'string') {
                formData.set(key, encodeURIComponent(value));
            }
        });
        
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            formData.append('photo', file);
        }
        


        const logementId = sessionStorage.getItem('logementId');
        if (logementId) {
            formData.append('id_logement', logementId);

            const addressData = getAddressFormData();

            if (!addressData.nom_rue ||!addressData.ville ||!addressData.cp) {
                alert('Tous les champs d\'adresse sont obligatoires.');
                return;
            }

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
                    localStorage.setItem('alertPopup', JSON.stringify({ message, type: 'success' }));
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
        console.log(selectedAmenagements);
        updateAmenagementsButtons();

        // Affichage de l'image du logement si présente (non modifié)
        let imageElement = document.getElementById('drop-photo');
        if (imageElement && formData.image) {
            imageElement.style.backgroundImage = "url('" + formData.image + "')";
        }
    }

    updateLogementInfo();
});
