// import des fonctions JS
import { displayNoteEtoiles } from './fonctions.js';

var header = document.getElementById('headerAccueilMobile');

// au chargement du dom
document.addEventListener('DOMContentLoaded', function() {
    adjustMarginTop();
    window.addEventListener('resize', adjustMarginTop);

    var cardTemplate = document.getElementsByClassName('card')[0];
    var cardsContainer = document.getElementById('cardsContainer');




    if ("content" in document.createElement("template")) {
        // on récupère les logements
        fetch('/api/getLogementsDataForCards')
            .then(response => response.json())
            .then(data => {
                data.forEach(logement => {
                    let cardContent = cardTemplate.content;
                
                    let divCard = document.createElement('div');
                    divCard.classList.add('card');

                    divCard.setAttribute('id', logement.id_logement);
                    
                    divCard.appendChild(cardContent.cloneNode(true));
                    
                    divCard.querySelector('.nomVille').textContent = logement.nom_ville.toUpperCase();
                    divCard.querySelector('.titre').textContent = logement.titre;
                    divCard.querySelector('.tarif').textContent = logement.prix_nuit_ttc + '€/nuit';
                    divCard.querySelector('.description').textContent = logement.description;
                
                    displayNoteEtoiles(divCard.querySelector('.note'), logement.moyenne_logement);

                    divCard.querySelector('.nbAvis').textContent = logement.nb_avis + ' avis';
                
                    cardsContainer.appendChild(divCard);
                });  
                
            });
    }
});

function adjustMarginTop() {
    var marginTopValue = (header.offsetHeight + 20) + 'px'; 
    cardsContainer.style.marginTop = marginTopValue; 
}
