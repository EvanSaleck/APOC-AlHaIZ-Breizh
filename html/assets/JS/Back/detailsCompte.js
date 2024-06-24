// Au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    var compteContainer = document.querySelector('.compte');

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

                console.log(compte.date_cni_fin_valid)
 
                document.querySelector('.nom').textContent = compte.nom;
                document.querySelector('.prenom').textContent = compte.prenom;
                document.querySelector('.civilite').textContent = compte.civilite;
                document.querySelector('.rue').textContent = compte.numero_rue + ' ' + compte.nom_rue;
                document.querySelector('.codePostal').textContent = compte.code_postal;
                document.querySelector('.ville').textContent = compte.nom_ville;
                document.querySelector('.pays').textContent = compte.pays;
                document.querySelector('.pseudo').textContent = compte.pseudo;
                document.querySelector('.email').textContent = compte.e_mail;
                document.querySelector('.dateNaissance').textContent = compte.ddn;
                document.querySelector('.cni').textContent = compte.date_cni_fin_valid;
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données du compte:', error);
            compteContainer.innerHTML = '<h2 class="error">Erreur lors du chargement des détails du compte.</h2>';
        });
});