import * as utils from '../utils.js';

// au chargement du dom
var prixMin;
var prixMax;

document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('depts');

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
                    noResultMessage();
                }else{
                    data.sort(() => Math.random() - 0.5);
                    data.forEach(logement => {
                        let cardContent = cardTemplate.content;

                        var cardsContainer = document.getElementById('cardsContainer');
                        cardsContainer.innerHTML = '';

                        if (data.length == 0) {
                            noResultMessage();
                        } else {
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
                                    // on met a jour le prix min et max
                                    if (prixMin == undefined || parseFloat(logement.prix_nuit_ttc) < parseFloat(prixMin)) {
                                        prixMin = logement.prix_nuit_ttc;
                                    } else if (prixMax == undefined || parseFloat(logement.prix_nuit_ttc) > parseFloat(prixMax)) {
                                        prixMax = logement.prix_nuit_ttc;
                                    }

                                    divCard.querySelector('.description').textContent = logement.description;
                                    // divCard.querySelector('.nbAvis').textContent = logement.nb_avis + ' avis';
                                    // utils.displayNoteEtoiles(divCard.querySelector('.note'), logement.moyenne_logement);
                                    let pathImage = logement.image_principale;
                                    divCard.querySelector('.imagePrincipale').src = pathImage;
                                    
                                    // utils.fileExists(pathImage).then(exists => {
                                    //     if (exists) {
                                    //     } else {
                                    //         divCard.querySelector('.imgbox').textContent = 'Erreur lors du chargement de l\'image';
                                    //     }
                                    // });

                                    divCard.addEventListener('click', function() {
                                        sessionStorage.setItem('idLogement', logement.id_logement);
                                        window.location.href = `/logement/`;
                                        sessionStorage.setItem('idLogement', logement.id_logement);
                                        window.location.href = `/logement/`;
                                    });
                                    divCard.setAttribute('data-dept', logement.code_postal.substring(0, 2));
                                    divCard.setAttribute('data-tarif', logement.prix_nuit_ttc);
                                } else {
                                    divCard.querySelector('.description').textContent = "Erreur lors du chargement des données du logement";
                                }
                                
                                cardsContainer.appendChild(divCard);
                            });
                            // on met a jour le prix min et max
                            document.querySelector('#prixFiltresContainer #prixMin').textContent = prixMin;
                            document.querySelector('#prixFiltresContainer #prixMax').textContent = prixMax;
                            // on ajoute des attributs min et max au bouton de prix
                            document.getElementById('btnPrix').setAttribute('data-min', prixMin);
                            document.getElementById('btnPrix').setAttribute('data-max', prixMax);

                            // on met a jour le prix min et max de la modale
                            document.querySelector('.price-input input.input-min').value = prixMin;
                            document.querySelector('.price-input input.input-max').value = prixMax;
                            document.querySelector('.range-input input.range-min').value = prixMin;
                            document.querySelector('.range-input input.range-max').value = prixMax;

                            // on ajuste les attributs min et max des sliders
                            document.querySelector('.range-input input.range-min').setAttribute('min', prixMin);
                            document.querySelector('.range-input input.range-min').setAttribute('max', prixMax);
                            document.querySelector('.range-input input.range-max').setAttribute('min', prixMin);
                            document.querySelector('.range-input input.range-max').setAttribute('max', prixMax);

                            // on initialise le slider
                            document.querySelector('.slider .progress').style.left = "0%";
                            document.querySelector('.slider .progress').style.right = "0%";
                        }
                        
                    });  
                }
                
                
            });
    }
    // gestion des filtres

    // filtre de departement
    var selectBox = document.getElementById('select-box');
    var dropdown = document.getElementById('dropdown');
    var searchInput = document.getElementById('search');
    var optionsList = document.getElementById('options-list');
    var selectedItems = document.getElementById('selected-items');
    var filters = {
        depts: [],
        commune: []
    };    

    selectBox.addEventListener('click', function(event) {
        toggleDropdown();
        event.stopPropagation();  
    });

    searchInput.addEventListener('keyup', function() {
        filterOptions();
    });

    optionsList.addEventListener('click', function(event) {
        var target = event.target;
        if (target.tagName === 'LI') {
            toggleSelection(target);
        }
    });

    document.addEventListener('click', function(event) {
        if (!selectBox.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }

        var wrapper = document.getElementById('wrapper');
        if (wrapper.style.display === 'block' && !document.getElementById('btnPrix').contains(event.target) && !wrapper.contains(event.target)) {
            wrapper.style.display = 'none';
        }

    });

    selectedItems.addEventListener('wheel', function(event) {
        if (event.deltaY !== 0) {
            event.preventDefault();
            selectedItems.scrollLeft += event.deltaY;
        }
    });

    function toggleDropdown() {
        dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
    }

    function filterOptions() {
        var filter = searchInput.value.toUpperCase();
        var li = optionsList.getElementsByTagName('li');

        for (var i = 0; i < li.length; i++) {
            var txtValue = li[i].textContent || li[i].innerText;
            li[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? '' : 'none';
        }
    }

    function toggleSelection(target) {
        var value = target.getAttribute('data-value');
        if (filters['depts'].includes(value)) {
            filters['depts'] = filters['depts'].filter(function(val) { return val !== value; });
            target.classList.remove('selected');
        } else {
            filters['depts'].push(value);
            target.classList.add('selected');
        }
        updateSelectedItems();
    }

    function updateSelectedItems() {
        applyFilters();
        selectedItems.innerHTML = '';
        if (filters['depts'].length > 0) {
            filters['depts'].forEach(function(value) {
                var item = document.createElement('div');
                item.className = 'selected-item';
                item.innerText = optionsList.querySelector('li[data-value="' + value + '"]').innerText;

                var removeIcon = document.createElement('span');
                removeIcon.innerText = '✖';
                removeIcon.addEventListener('click', function(event) {
                    removeSelection(value);
                    event.stopPropagation(); 
                });

                item.appendChild(removeIcon);
                selectedItems.appendChild(item);
            });
        } else {
            selectedItems.innerText = 'Sélectionnez des options';
        }
    }

    function removeSelection(value) {
        filters['depts'] = filters['depts'].filter(function(val) { return val !== value; });
        var optionItems = optionsList.getElementsByTagName('li');
        for (var i = 0; i < optionItems.length; i++) {
            if (optionItems[i].getAttribute('data-value') === value) {
                optionItems[i].classList.remove('selected');
            }
        }
        updateSelectedItems();
    }

    function applyFilters() {
        var noResult = document.querySelector('.no-result');
        if(noResult) {
            noResult.remove();
        }

        // on met la classe d-none none aux éléments qui ne correspondent pas aux filtres
        var cards = document.getElementsByClassName('card');
        for (var i = 0; i < cards.length; i++) {
            var card = cards[i];
            var dept = card.getAttribute('data-dept');
            if (filters['depts'].length > 0 && !filters['depts'].includes(dept)
                || parseFloat(card.getAttribute('data-tarif')) < parseFloat(document.getElementById('btnPrix').getAttribute('data-min'))
                || parseFloat(card.getAttribute('data-tarif')) > parseFloat(document.getElementById('btnPrix').getAttribute('data-max'))
            ) {
                card.classList.add('d-none');                
            } else {
                card.classList.remove('d-none');
            }
        }

        if(cardsContainer.querySelectorAll('.card:not(.d-none)').length === 0) {
            noResultMessage();
        }
    }

    function noResultMessage() {
        var noResult = document.createElement('div');
        noResult.classList.add('no-result');
        noResult.innerHTML = `<div id="not-found">
            <h2>Aucun logement trouvé</h2>
            <img src="/assets/imgs/alerts/notFound.jpeg" id="not-found-image" alt="Aucun résultat">
        </div>`;
        cardsContainer.appendChild(noResult);        
    }

    //filtre de prix
    const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
    let priceGap = 10;

    // au click sur le bouton, on affiche la modale
    document.getElementById('btnPrix').addEventListener('click', function() {
        // on toggle la visibilité de la modale
        var wrapper = document.getElementById('wrapper');
        wrapper.style.display = (wrapper.style.display === 'none' || wrapper.style.display === '') ? 'block' : 'none';
    });
    
    // Écouteurs pour les inputs de prix
    priceInput.forEach(input => {
        input.addEventListener("input", e => {
            let minPrice = parseFloat(priceInput[0].value),
                maxPrice = parseFloat(priceInput[1].value);

            if (isNaN(minPrice) || isNaN(maxPrice)) {
                if (isNaN(minPrice)) {
                    minPrice = parseFloat(rangeInput[0].min);
                }

                if (isNaN(maxPrice)) {
                    maxPrice = parseFloat(rangeInput[1].max);
                }
            } else {
                // Assurer que minPrice est toujours inférieur ou égal à maxPrice
                if (minPrice > maxPrice) {
                    if (e.target.className === "input-min") {
                        minPrice = maxPrice - priceGap;
                    } else {
                        maxPrice = minPrice + priceGap;
                    }
                }

                if ((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max) {
                    if (e.target.className === "input-min") {
                        rangeInput[0].value = minPrice;
                        range.style.left = ((minPrice / rangeInput[0].max) * 100) + "%";
                    } else {
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                    }
                }

                if (maxPrice > rangeInput[1].max) {
                    maxPrice = rangeInput[1].max;
                    range.style.right = "0%";
                } else if (minPrice < rangeInput[0].min) {
                    minPrice = rangeInput[0].min;
                    range.style.left = "0%";
                }
            }

            document.getElementById('btnPrix').textContent = `Prix : ${minPrice}€ - ${maxPrice}€`;
            document.getElementById('btnPrix').setAttribute('data-min', minPrice);
            document.getElementById('btnPrix').setAttribute('data-max', maxPrice);
            applyFilters();
        });
    });

    // Écouteurs pour les inputs de range
    rangeInput.forEach(input => {
        input.addEventListener("input", e => {
            let minVal = parseFloat(rangeInput[0].value);
            let maxVal = parseFloat(rangeInput[1].value);

            if(maxVal + priceGap > rangeInput[1].max) {
                maxVal = rangeInput[1].max;
            }

            // Assurer que minVal est toujours inférieur ou égal à maxVal
            if (minVal > maxVal - priceGap) {
                if (e.target.className === "range-min") {
                    minVal = maxVal - priceGap;
                    rangeInput[0].value = minVal;
                } else {
                    maxVal = minVal + priceGap;
                    rangeInput[1].value = maxVal;
                }
            }

            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;

            let leftPercent = (minVal / rangeInput[0].max) * 100;
            let rightPercent = 100 - (maxVal / rangeInput[1].max) * 100;

            if (rightPercent < 0) {
                rightPercent = 0;
            }

            range.style.left = leftPercent + "%";
            range.style.right = rightPercent + "%";

            // Mettre à jour le texte du bouton
            document.getElementById('btnPrix').textContent = `Prix : ${minVal}€ - ${maxVal}€`;
            document.getElementById('btnPrix').setAttribute('data-min', minVal);
            document.getElementById('btnPrix').setAttribute('data-max', maxVal);
            applyFilters();
        });
    });

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