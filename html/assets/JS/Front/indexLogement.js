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
                        
                        if (logement.nom_ville && logement.titre && logement.prix_nuit_ttc && logement.description) {
                            divCard.querySelector('.nomVille').textContent = logement.nom_ville.toUpperCase();
                            divCard.querySelector('.titre').textContent = logement.titre;
                            divCard.querySelector('.tarif').textContent = logement.prix_nuit_ttc + '€/nuit';
                            divCard.querySelector('.description').textContent = logement.description;
                            divCard.querySelector('.nbAvis').textContent = logement.nb_avis + ' avis';
                            displayNoteEtoiles(divCard.querySelector('.note'), logement.moyenne_logement);
                            let pathImage = logement.image_principale + '.svg';
                            
                            fileExists(pathImage).then(exists => {
                                if (exists) {
                                    divCard.querySelector('.imagePrincipale').src = pathImage;
                                } else {
                                    divCard.querySelector('.imagePrincipale').src = '/assets/imgs/error.png';
                                }
                            });

                            divCard.addEventListener('click', function() {
                                window.location.href = `/logement/${logement.id_logement}`;
                            });
                        } else {
                            divCard.querySelector('.description').textContent = "Erreur lors du chargement des données du logement";
                            divCard.querySelector('.imagePrincipale').src = '/assets/imgs/error.png';
                        }
                        
                        cardsContainer.appendChild(divCard);
                    });  
                }
                
                
            });
    }
});

function adjustMarginTop() {
    var marginTopValue = (header.offsetHeight + 20) + 'px'; 
    cardsContainer.style.marginTop = marginTopValue; 
}
