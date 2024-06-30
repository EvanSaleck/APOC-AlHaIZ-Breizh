import * as utils from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    const hiddenInput = document.getElementById('amenagements');
    let selectedAmenagements = [];

    const amenagementsBtns = document.querySelectorAll("#amenagementsBoutons button");

    // Fonction pour mettre à jour les boutons d'aménagement
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

    // Ajout d'un listener sur chaque bouton d'aménagement
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

    // Fonction pour mettre à jour l'aperçu de l'image
    function updatePhotoName(files) {
        const imagePreviewElement = document.getElementById('drop-photo');
        if (files.length > 0) {
            imagePreviewElement.style.backgroundImage = `url('${URL.createObjectURL(files[0])}')`;
        } else {
            imagePreviewElement.style.backgroundImage = "none";
        }
    }
     
    // ajut d'un listener sur le formulaire pour traiter la soumission du formulaire
    document.getElementById('formNewLogement').addEventListener('submit', function(event) {
        event.preventDefault();
        window.scroll({ top: 0, behavior: 'smooth' });

        const formData = new FormData(this);
        formData.append('pays', 'France');
        formData.append('etat', '');

        // Ajout de l'image
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            formData.append('photo', file);
        }

        // Ajout des aménagements sélectionnés
        const logementId = sessionStorage.getItem('logementId');
        if (logementId) {
            formData.append('id_logement', logementId);

            fetch('/api/processFormUpdateLogement', {
                method: 'POST',
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                const message = 'Le logement a bien été mis à jour !';
                utils.ThrowAlertPopup(message, 'success');
                localStorage.setItem('alertPopup', JSON.stringify({ message, type: 'success' }));
                window.location.href = '/back/logements';
            })
            .catch((error) => {
                utils.ThrowAlertPopup(`Erreur: ${error}`, 'error');
            });
        } else {
            utils.ThrowAlertPopup('Erreur: ID du logement manquant.', 'error');
        }
    });

    function updateLogementInfo() {
        const logementId = sessionStorage.getItem('logementId');
        if (!logementId) {
            utils.ThrowAlertPopup('Erreur: ID du logement manquant.', 'error');
            return;
        }

        // Récupération des données du logement
        fetch(`/api/getLogementDataById/${logementId}`)
        .then(response => response.json())
        .then(data => {
            if (!data || data.length === 0) {
                utils.ThrowAlertPopup('Erreur: Données du logement non trouvées.', 'error');
                return;
            }

            // Remplissage des champs du formulaire
            const logement = data[0];
            document.getElementById('titre').value = logement['titre'];
            document.getElementById('ville').value = logement['nom_ville'];
            document.getElementById('tarif').value = parseFloat(logement['prix_nuit_ttc']);
            document.getElementById('nom_rue').value = logement['nom_rue'];
            document.getElementById('cp').value = logement['code_postal'];
            document.getElementById('complement_adresse').value = logement['complement'];
            document.getElementById('accroche').textContent = logement['accroche'];
            document.getElementById('description').textContent = logement['description'];
            document.getElementById('surface').value = logement['surface_hab'];
            document.getElementById('nbPersMax').value = logement['personnes_max'];
            document.getElementById('nbChambres').value = logement['nb_chambres'];
            document.getElementById('nbLitsSimples').value = logement['nb_lits_simples'];
            document.getElementById('nbLitsDoubles').value = logement['nb_lits_doubles'];
            document.getElementById('delaiResaArrivee').value = logement['avance_resa_min'];
            document.getElementById('dureeMinLoc').value = logement['duree_min_location'];
            document.getElementById('delaiAnnulMax').value = logement['delai_annul_max'];

            const imageElement = document.getElementById('drop-photo');
            imageElement.style.backgroundImage = `url('${logement['image_principale']}')`;

            // Récupération des aménagements du logement
            fetch(`/api/getAmenagementsOfLogementById/${logementId}`)
            .then(response => response.json())
            .then(dataAm => {
                const idsAmenagementsActifs = dataAm.map(amenagement => amenagement.id_amenagement);
                selectedAmenagements = idsAmenagementsActifs.map(id => id.toString());
                updateAmenagementsButtons();
                hiddenInput.value = JSON.stringify(selectedAmenagements);
            })
            .catch(error => {
                utils.ThrowAlertPopup(`Erreur lors de la récupération des aménagements: ${error}`, 'error');
            });
        })
        .catch(error => {
            utils.ThrowAlertPopup(`Erreur lors de la récupération des données du logement: ${error}`, 'error');
        });
    }

    updateLogementInfo();
});
