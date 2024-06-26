import * as utils from '../utils.js';
// Au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    var compteContainer = document.querySelector('.compte');
    
    document.querySelector('.mdp').addEventListener('click', togglePasswordModification);
    document.querySelector('.annul').addEventListener('click', cancelPasswordModification);
    // document.querySelector('.update').addEventListener('click', enableProfileModification);
    // document.querySelector('.save').addEventListener('click', saveProfileChanges);
    // document.getElementById('annulmodif').addEventListener('click', cancelProfileModification);


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
                document.querySelector('.nom').textContent = compte.nom;
                document.querySelector('.prenom').textContent = compte.prenom;
                document.querySelector('.civilite').textContent = compte.civilite;
                document.querySelector('.rue').textContent = compte.numero_rue + ' ' + compte.nom_rue;
                document.querySelector('.codePostal').textContent = compte.code_postal;
                document.querySelector('.ville').textContent = compte.nom_ville;
                document.querySelector('.pays').textContent = compte.pays;
                document.querySelector('.pseudo').textContent = compte.pseudo;
                document.querySelector('.email').textContent = compte.e_mail;
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données du compte:', error);
            compteContainer.innerHTML = '<h2 class="error">Erreur lors du chargement des détails du compte.</h2>';
        });
});

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

function cancelPasswordModification(){
    document.getElementById('zonemodif').classList.add('d-none');
    document.querySelector('.mdp').innerHTML = 'Modifier Mot de passe';
    document.querySelector('.annul').classList.add('d-none');
}