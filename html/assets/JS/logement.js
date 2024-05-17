// au chargement du dom
document.addEventListener('DOMContentLoaded', function() {
    var cardTemplate = document.getElementsByClassName('card')[0];
    var cardsContainer = document.getElementById('cardsContainer');

    if ("content" in document.createElement("template")) {
        // on récupère les logements
        fetch('/api/getLogements')
            .then(response => response.json())
            .then(data => {
                data.forEach(logement => {
                    let cardContent = cardTemplate.content;
                
                    let divCard = document.createElement('div');
                    divCard.classList.add('card');
                    
                    divCard.appendChild(cardContent.cloneNode(true));
                    
                    divCard.querySelector('.lieu').textContent = logement.lieu;
                    divCard.querySelector('.logement').textContent = logement.type;
                    divCard.querySelector('.tarif').textContent = logement.tarif;
                    divCard.querySelector('.description').textContent = logement.description;
                    divCard.querySelector('.noteEtoile').setAttribute('src', logement.noteEtoileSrc);
                    divCard.querySelector('.Avis').textContent = logement.avis;
                
                    cardsContainer.appendChild(divCard);
                });
                
                
            });
    }
});