import * as utils from '../utils.js';

document.addEventListener('DOMContentLoaded', function() {
    var compteContainer = document.querySelector('.compte');
    
    // Ajout des event listeners
    document.querySelector('.mdp').addEventListener('click', togglePasswordModification);
    document.querySelector('.annul').addEventListener('click', cancelPasswordModification);
    document.querySelector('.update').addEventListener('click', enableProfileModification);
    document.querySelector('.save').addEventListener('click', saveProfileChanges);
    document.getElementById('annulmodif').addEventListener('click', cancelProfileModification);

    // Récupération des données du compte
    fetch('/api/getCompteProprioDetails')
        .then(response => response.json())
        .then(data => {
            console.log('Données du compte:', data);
            if (data.length === 0) {
                compteContainer.innerHTML = '<h2 class="error">Détails du compte non trouvés</h2>';
            } else {
                var compte = data[0];
                let img = new Image();
                img.alt = "Profil";

                const setImageSource = (source) => {
                    img.src = source;
                    document.querySelector('.imgProfil').src = img.src;
                };

                // On charge l'image de profil
                setImageSource(compte.photo_profil);
                
                img.onerror = () => {
                    // Si l'image n'est pas trouvée, on charge l'image par défaut
                    console.log('Image non trouvée, chargement de l\'image par défaut...');
                    setImageSource('/assets/imgs/person-fill.svg');
                };


                // Remplissage des champs
                document.querySelector('.nom').value = compte.nom;
                document.querySelector('.prenom').value = compte.prenom;
                document.querySelector('.civilite').value = compte.civilite;
                document.querySelector('.rue').value = compte.numero_rue + ' ' + compte.nom_rue;
                document.querySelector('.codePostal').value = compte.code_postal;
                document.querySelector('.ville').value = compte.nom_ville;
                document.querySelector('.pays').value = compte.pays;
                document.querySelector('.pseudo').value = compte.pseudo;
                document.querySelector('.email').value = compte.e_mail;
                document.querySelector('.dateNaissance').value = compte.ddn;
                document.querySelector('.cni').value = compte.date_cni_fin_valid;

                // Stockage des données originales
                storeOriginalProfileData();
            }
        })
        // .catch(error => {
        //     console.error('Erreur lors de la récupération des données du compte:', error);
        //     compteContainer.innerHTML = '<h2 class="error">Erreur lors du chargement des détails du compte.</h2>';
        // });
});

let originalProfileData = {};

// Fonction pour stocker les données originales du profil
function storeOriginalProfileData() {
    const fields = document.querySelectorAll('.infoPer input, .infoCo input, .infoPer select');
    fields.forEach(field => {
        originalProfileData[field.className] = field.value;
    });
}

// Fonction pour afficher ou masquer la zone de modification du mot de passe
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

        // Vérifier si les champs sont vides
        if (oldPwd === '' || newPwd === '' || confPwd === '') return utils.ThrowAlertPopup('Veuillez remplir tous les champs', 'error');

        // Vérifier si le nouveau mot de passe contient au moins 8 caractères
        if (newPwd.length < 8) return utils.ThrowAlertPopup('Le mot de passe doit contenir au moins 8 caractères', 'error');

        // Vérifier si le nouveau mot de passe est différent de l'ancien
        if (newPwd === oldPwd) return utils.ThrowAlertPopup('Le nouveau mot de passe doit être différent de l\'ancien', 'error');

        // Création du formulaire
        let formData = new FormData(); 
        formData.append('oldPwd', oldPwd);
        formData.append('newPwd', newPwd);
        formData.append('confPwd', confPwd);
        formData.append('id', JSON.parse(sessionStorage.getItem('Proprio')).id_compte);

        // Vérifier si les mots de passe correspondent
        if(newPwd === confPwd){
            fetch('/api/updatePassword', {
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

    document.querySelector('.cni').disabled = true;
    
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
    const ddn = document.querySelector('.dateNaissance').value;
    const rue = document.querySelector('.rue').value;
    const codePostal = document.querySelector('.codePostal').value;
    const ville = document.querySelector('.ville').value;
    const pays = document.querySelector('.pays').value;

    // Création du formulaire 
    let formData = new FormData();
    formData.append('pseudo', pseudo);
    formData.append('email', email);
    formData.append('nom', nom);
    formData.append('prenom', prenom);
    formData.append('civilite', civilite);
    formData.append('ddn', ddn);
    formData.append('rue', rue);
    formData.append('codePostal', codePostal);
    formData.append('ville', ville);
    formData.append('pays', pays);
    formData.append('id', JSON.parse(sessionStorage.getItem('Proprio')).id_compte);

    // Vérifier si les champs sont vides
    if(pseudo === '' || email === '' || nom === '' || prenom === '' || civilite === '' || ddn === '' || rue === '' || codePostal === '' || ville === '' || pays === ''){
        return utils.ThrowAlertPopup('Veuillez remplir tous les champs', 'error');
    }

    // if(originalProfileData.pseudo == pseudo && originalProfileData.email == email && originalProfileData.nom == nom && originalProfileData.prenom == prenom && originalProfileData.civilite == civilite && originalProfileData.ddn == ddn  && originalProfileData.codePostal == codePostal && originalProfileData.ville == ville && originalProfileData.pays == pays){
    //     return utils.ThrowAlertPopup('Aucune modification détectée', 'error');
    // }

    // Envoi de la requête
    fetch('/api/updateProfile', {
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
