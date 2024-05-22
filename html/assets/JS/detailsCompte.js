// Au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    var compteContainer = document.querySelector('.compte');

    fetch('/api/getCompteClientDetails')
        .then(response => response.json())
        .then(data => {
            console.log('Données du compte:', data);
            if (data.length === 0) {
                compteContainer.innerHTML = '<h2 class="error">Détails du compte non trouvés ಥ_ಥ</h2>';
            } else {
                var compte = data[0];
                document.querySelector('.imgProfil').src = compte.photo_profil || '/assets/imgs/default.png';
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
