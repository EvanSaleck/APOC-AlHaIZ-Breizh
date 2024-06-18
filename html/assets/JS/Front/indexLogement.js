import * as utils from '../utils.js';

// au chargement du dom
document.addEventListener('DOMContentLoaded', function() {
    adjustMarginTop();
    window.addEventListener('resize', adjustMarginTop);

    // utils.ThrowAlertPopup('Bienvenue sur notre site de location de logements !', 'success');

    var cardTemplate = document.getElementsByClassName('card')[0];
    var cardsContainer = document.getElementById('cardsContainer');

    if ("content" in document.createElement("template")) {
        // on récupère les logements
        fetch('/api/getLogementsDataForCards')
            .then(response => response.json())
            .then(data => {
                // Test tableau vide
                // data = [];
                
                if(data.length == 0){
                    cardsContainer.innerHTML = '<h2 class="error">Aucun logement trouvé ಥ_ಥ</h2>';
                }else{
                    data.sort(() => Math.random() - 0.5);
                    data.forEach(logement => {
                        let cardContent = cardTemplate.content;
                        
                        let divCard = document.createElement('div');
                        divCard.classList.add('card');
                        
                        divCard.setAttribute('id', logement.id_logement);
                        
                        divCard.appendChild(cardContent.cloneNode(true));
                        
                        if (logement.nom_ville && logement.titre && logement.prix_nuit_ttc) {
                            divCard.querySelector('.nomVille').textContent = logement.nom_ville.toUpperCase();
                            divCard.querySelector('.titre').textContent = logement.titre;
                            divCard.querySelector('.tarif').textContent = logement.prix_nuit_ttc + '€/nuit';
                            divCard.querySelector('.description').textContent = logement.description;
                            divCard.querySelector('.nbAvis').textContent = logement.nb_avis + ' avis';
                            utils.displayNoteEtoiles(divCard.querySelector('.note'), logement.moyenne_logement);
                            let pathImage = logement.image_principale;
                            
                            utils.fileExists(pathImage).then(exists => {
                                if (exists) {
                                    divCard.querySelector('.imagePrincipale').src = pathImage;
                                } else {
                                    divCard.querySelector('.imgbox').textContent = 'Erreur lors du chargement de l\'image';
                                }
                            });

                            divCard.addEventListener('click', function() {
                                sessionStorage.setItem('idLogement', logement.id_logement);
                                window.location.href = `/logement/`;
                                sessionStorage.setItem('idLogement', logement.id_logement);
                                window.location.href = `/logement/`;
                            });
                        } else {
                            divCard.querySelector('.description').textContent = "Erreur lors du chargement des données du logement";
                        }
                        
                        cardsContainer.appendChild(divCard);
                    });  
                }
                
                
            });
    }
});

function adjustMarginTop() {
    var header = document.querySelector('#headerAccueilMobile');
    var cardsContainer = document.querySelector('#cardsContainer');

    if (header && cardsContainer) {
        if (header.offsetHeight > 0) {
            var marginTopValue = (header.offsetHeight + 20) + 'px'; 
            cardsContainer.style.marginTop = marginTopValue;
        } else {
            cardsContainer.style.marginTop = "90px";
        }
    }

}

