import * as utils from '../utils.js';

// Au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    var compteContainer = document.querySelector('.compte');
    
    document.querySelector('.mdp').addEventListener('click', togglePasswordModification);
    document.querySelector('.annul').addEventListener('click', cancelPasswordModification);
    document.querySelector('.update').addEventListener('click', enableProfileModification);
    document.querySelector('.save').addEventListener('click', saveProfileChanges);
    document.getElementById('annulmodif').addEventListener('click', cancelProfileModification);

    fetch('/api/getCompteClientDetails')
        .then(response => response.json())
        .then(data => {
            console.log('Données du compte:', data);
            if (data.length === 0) {
                compteContainer.innerHTML = '<h2 class="error">Détails du compte non trouvés</h2>';
            } else {
                var compte = data[0];
                let img = new Image();
                img.alt = "Profil";

                // Fonction pour définir la source de l'image
                const setImageSource = (source) => {
                    img.src = source;
                    document.querySelector('.imgProfil').src = img.src;
                };

                // Définir la source initiale de l'image
                setImageSource(compte.photo_profil);

                // Gestionnaire d'erreur pour charger une image par défaut
                img.onerror = () => {
                    console.log('Image non trouvée, chargement de l\'image par défaut...');
                    setImageSource('/assets/imgs/person-fill.svg');
                };

                document.querySelector('.nom').value = compte.nom;
                document.querySelector('.prenom').value = compte.prenom;
                document.querySelector('.civilite').value = compte.civilite;
                document.querySelector('.rue').value = compte.numero_rue + ' ' + compte.nom_rue;
                document.querySelector('.codePostal').value = compte.code_postal;
                document.querySelector('.ville').value = compte.nom_ville;
                document.querySelector('.pays').value = compte.pays;
                document.querySelector('.pseudo').value = compte.pseudo;
                document.querySelector('.email').value = compte.e_mail;

                // Stockage des données originales
                storeOriginalProfileData();
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données du compte:', error);
            compteContainer.innerHTML = '<h2 class="error">Erreur lors du chargement des détails du compte.</h2>';
        });
});

let originalProfileData = {};

function storeOriginalProfileData() {
    const fields = document.querySelectorAll('.infoPer input, .infoCo input, .infoPer select');
    fields.forEach(field => {
        originalProfileData[field.className] = field.value;
    });
}

// Fonction pour activer/désactiver la modification du mot de passe
function togglePasswordModification(){
    const passwordZone = document.getElementById('zonemodif');
    const modifyButton = document.querySelector('.mdp');
    const cancelButton = document.querySelector('.annul');
    
    if(passwordZone.classList.contains('d-none')){
        passwordZone.classList.remove('d-none');
        modifyButton.innerHTML = 'Valider';
        cancelButton.classList.remove('d-none');
        let inputs = passwordZone.querySelectorAll('input');
        inputs.forEach(input => input.disabled = false);
    } else {
        const oldPwd = document.querySelector('.oldPwd').value;
        const newPwd = document.querySelector('.newPwd').value;
        const confPwd = document.querySelector('.confPwd').value;

        if (oldPwd === '' || newPwd === '' || confPwd === '') return utils.ThrowAlertPopup('Veuillez remplir tous les champs', 'error');

        if (newPwd.length < 8) return utils.ThrowAlertPopup('Le mot de passe doit contenir au moins 8 caractères', 'error');

        if (newPwd === oldPwd) return utils.ThrowAlertPopup('Le nouveau mot de passe doit être différent de l\'ancien', 'error');

        let formData = new FormData(); 
        formData.append('oldPwd', oldPwd);
        formData.append('newPwd', newPwd);
        formData.append('confPwd', confPwd);
        formData.append('id', JSON.parse(sessionStorage.getItem('User')).id_compte);

        // Vérifier si les mots de passe correspondent
        if(newPwd === confPwd){
            fetch('/api/updateCliPassword', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if(data == "Mot de passe modifie"){
                    utils.ThrowAlertPopup('Mot de passe modifié avec succès', 'success');
                    passwordZone.classList.add('d-none');
                    passwordZone.querySelectorAll('input').forEach(input => input.value = '');
                    modifyButton.innerHTML = 'Modifier Mot de passe';
                    cancelButton.classList.add('d-none');
                } else if(data == "Mot de passe incorrect"){
                    utils.ThrowAlertPopup('Mot de passe incorrect', 'error');
                } else {
                    utils.ThrowAlertPopup('Erreur lors de la modification du mot de passe', 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:' + error, 'error');
                utils.ThrowAlertPopup('Erreur lors de la modification du mot de passe', 'error');
            });
        } else {
            utils.ThrowAlertPopup('Les mots de passe ne correspondent pas', 'error');
        }
    }
}

// Fonction pour annuler la modification du mot de passe
function cancelPasswordModification(){
    document.getElementById('zonemodif').classList.add('d-none');
    document.querySelector('.mdp').innerHTML = 'Modifier Mot de passe';
    document.querySelector('.annul').classList.add('d-none');
}

// Fonction pour activer la modification du profil 
function enableProfileModification(){
    const fields = document.querySelectorAll('.infoPer input, .infoCo input, .infoPer select');
    fields.forEach(field => {
        field.disabled = false;
    });
    
    document.querySelector('.update').classList.add('d-none');
    document.querySelector('.save').classList.remove('d-none');
    document.getElementById('annulmodif').classList.remove('d-none');
}

// Fonction pour annuler la modification du profil
function cancelProfileModification(){
    const fields = document.querySelectorAll('.infoPer input, .infoCo input, .infoPer select');
    fields.forEach(field => {
        field.value = originalProfileData[field.className];
        field.disabled = true;
    });
    
    document.querySelector('.update').classList.remove('d-none');
    document.querySelector('.save').classList.add('d-none');
    document.getElementById('annulmodif').classList.add('d-none');
}

// Fonction pour sauvegarder les modifications du profil
function saveProfileChanges(){
    const pseudo = document.querySelector('.pseudo').value;
    const email = document.querySelector('.email').value;
    const nom = document.querySelector('.nom').value;
    const prenom = document.querySelector('.prenom').value;
    const civilite = document.querySelector('.civilite').value;
    const rue = document.querySelector('.rue').value;
    const codePostal = document.querySelector('.codePostal').value;
    const ville = document.querySelector('.ville').value;
    const pays = document.querySelector('.pays').value;

    let formData = new FormData();
    formData.append('pseudo', pseudo);
    formData.append('email', email);
    formData.append('nom', nom);
    formData.append('prenom', prenom);
    formData.append('civilite', civilite);
    formData.append('rue', rue);
    formData.append('codePostal', codePostal);
    formData.append('ville', ville);
    formData.append('pays', pays);
    formData.append('id', JSON.parse(sessionStorage.getItem('User')).id_compte);

    if(pseudo === '' || email === '' || nom === '' || prenom === '' || civilite === '' || rue === '' || codePostal === '' || ville === '' || pays === ''){
        return utils.ThrowAlertPopup('Veuillez remplir tous les champs', 'error');
    }

    // Vérifier si l'email est valide
    fetch('/api/updateCliProfile', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data == "Profil modifie"){
            utils.ThrowAlertPopup('Profil mis à jour avec succès', 'success');
            const fields = document.querySelectorAll('.infoPer input, .infoCo input, .infoPer select');
            fields.forEach(field => field.disabled = true);
            document.querySelector('.update').classList.remove('d-none');
            document.querySelector('.save').classList.add('d-none');
            document.getElementById('annulmodif').classList.add('d-none');
            
            // Mettre à jour les données originales
            storeOriginalProfileData();
        } else {
            utils.ThrowAlertPopup('Erreur lors de la mise à jour du profil', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        utils.ThrowAlertPopup('Erreur lors de la mise à jour du profil', 'error');
    });
}
