// TODO : supprimer la répétition de code (faire fonctions pour les filtres)

document.addEventListener('DOMContentLoaded', function() {
    // toogle de l'affichage des filtres sur mobile
    document.getElementById('buttonfiltresMobile').addEventListener('click', function() {
        var filters = document.getElementById('filtres');

        if (filters.style.display === 'none' || filters.style.display === '') {
            filters.style.display = 'flex';
        } else {
            filters.style.display = 'none';
        }


    });

    var communes = [];
    var proprietaires = [];

    // on initialise les filtres dans le session storage
    if(sessionStorage.getItem('filters') == null){
        sessionStorage.setItem('filters', JSON.stringify({
            depts: [],
            communes: [],
            proprietaires: [],
            prix: {
                min: null,
                max: null
            },
            date: {
                start: null,
                end: null
            },
            tri: 'asc'
        }));
    }

    adjustMarginTop();
    window.addEventListener('resize', adjustMarginTop);    
    var filters,isAscending,prixMin,prixMax,cardTemplate,cardsContainer;

    if ("content" in document.createElement("template")) {
        fetchLogementsData(); 
    } 


    // on reset les dates dans le sessio,n storage
    var filters = JSON.parse(sessionStorage.getItem('filters'));
    filters.date.start = null;
    filters.date.end = null;
    sessionStorage.setItem('filters', JSON.stringify(filters));

    
    function fetchLogementsData() {
        // on récupère les dates dans le session storage
        var filters = JSON.parse(sessionStorage.getItem('filters'));

        // on initialise le date picker
        flatpickr("#rangePicker", {
            // permet de choisir une range de date
            mode: "range",
            dateFormat: "Y-m-d",
            // permet de mettre le date picker en français
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                    longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
                },
                months: {
                    shorthand: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                    longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                },
            },
            // permet la mise à jour des filtres
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {

                    startDate = selectedDates[0].toISOString().split('T')[0];
                    endDate = selectedDates[1].toISOString().split('T')[0];

                    // on corrige les deux lignes précédentes qui renvoient un jour de moins a chaque fois
                    startDate = new Date(startDate);
                    endDate = new Date(endDate);
                    startDate.setDate(startDate.getDate() + 1);
                    endDate.setDate(endDate.getDate() + 1);
                    startDate = startDate.toISOString().split('T')[0];
                    endDate = endDate.toISOString().split('T')[0];
                    
                    
                    // on met à jour dans le session storage
                    var filters = JSON.parse(sessionStorage.getItem('filters'));
                    filters.date.start = startDate;
                    filters.date.end = endDate;
                    sessionStorage.setItem('filters', JSON.stringify(filters));

                    applyFilters();
                }
            },
        });

        // utilisation des filters du session storage
        filters = JSON.parse(sessionStorage.getItem('filters'));
        isAscending =  filters.tri === 'asc' ? true : false;
        startDate = filters.date.start;
        endDate = filters.date.end;

        cardTemplate = document.getElementsByClassName('card')[0];
        cardsContainer = document.getElementById('cardsContainer');

        var filters = JSON.parse(sessionStorage.getItem('filters'));
        var startDate = filters.date.start;
        var endDate = filters.date.end;

        // Construire l'URL avec les dates
        let url = `/api/getLogementsDataForCards`;
        // Effectuer la requête et traiter les données
        fetch(url)
            .then(response => response.json())
            .then(data => {
                let logementsData = data;
                displayLogements(logementsData);
                initFilters();
                setupFilters();
                setupSorting();
                applyFilters();
            });

    }    

    // affichage des cards de logements sur la page
    function displayLogements(data) {
        cardsContainer.innerHTML = '';     
        if(data.length == 0){
            noResultMessage();
        } else {
            // on trie les logements par prix
            data.sort((a, b) => isAscending ? parseFloat(a.prix_nuit_ttc) - parseFloat(b.prix_nuit_ttc) : parseFloat(b.prix_nuit_ttc) - parseFloat(a.prix_nuit_ttc));
            data.forEach(logement => {
                let cardContent = cardTemplate.content;

                let divCard = document.createElement('div');
                divCard.classList.add('card');

                divCard.setAttribute('id', logement.id_logement);

                divCard.appendChild(cardContent.cloneNode(true));

                if (logement.nom_ville && logement.titre && logement.prix_nuit_ttc) {
                    divCard.querySelector('.nomVille').textContent = logement.nom_ville.toUpperCase() + ' (' + logement.code_postal.substring(0, 2) + ')';
                    divCard.querySelector('.titre').textContent = logement.titre;
                    divCard.querySelector('.tarif').textContent = logement.prix_nuit_ttc + '€/nuit';
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

                    divCard.addEventListener('click', function() {
                        sessionStorage.setItem('idLogement', logement.id_logement);
                        window.location.href = `/logement/`;
                    });
                    divCard.setAttribute('data-dept', logement.code_postal.substring(0, 2));
                    divCard.setAttribute('data-tarif', logement.prix_nuit_ttc);
                    divCard.setAttribute('data-proprietaire', logement.id_compte);

                    // on créé le nom de la ville avec de dept
                    let villeDept = logement.nom_ville + ' (' + logement.code_postal.substring(0, 2) + ')';
                    if(!communes.includes(villeDept)){
                        communes.push(villeDept);
                    }

                    // on push que si le tuplue ville et dept n'existe pas
                    // if (!communes.some(commune => commune.ville === logement.nom_ville && 
                    //     commune.dept === logement.code_postal.substring(0, 2))) {
                    //     communes.push({
                    //         ville: logement.nom_ville,
                    //         dept: logement.code_postal.substring(0, 2)
                    //     });
                    // }

                    // meme chose pour les proprietaires
                    let nomPrenom = logement.nom.toUpperCase() + ' ' + logement.prenom;

                    // on push que si le tuple id et nomPrenom n'existe pas
                    if (!proprietaires.some(prop => prop.id === logement.id_compte && prop.nomPrenom === nomPrenom)) {
                        proprietaires.push({
                            id: logement.id_compte,
                            nomPrenom: nomPrenom
                        });
                    }
                } else {
                    divCard.querySelector('.description').textContent = "Erreur lors du chargement des données du logement";
                }

                cardsContainer.appendChild(divCard);
            });
        }
    }

    // initialisation des filtres
    function initFilters() {
        var optionsList = document.getElementById('options-list');

        var filters = JSON.parse(sessionStorage.getItem('filters'));
        var depts = filters.depts;
        // on pré-selection les depts
        depts.forEach(function(value) {
            var item = optionsList.querySelector('li[data-value="' + value + '"]');
            if (item) {
                item.classList.add('selected');
            }
        });

        updateSelectedItems();
        var filters = JSON.parse(sessionStorage.getItem('filters'));
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

        document.querySelector('.range-input input.range-max').value = prixMax;
    }

    // on met à jour les departements selectionnés dans l'input
    function updateSelectedItems() {
        let selectedItems = document.getElementById('selected-items');
        let optionsList = document.getElementById('options-list');

        selectedItems.innerHTML = '';
        var filters = JSON.parse(sessionStorage.getItem('filters'));
        if(filters.depts.length > 0) {
            filters.depts.forEach(function(value) {
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
            selectedItems.innerText = 'Choisir';
        }
    }

    // on supprime de l'input le departement selectionné
    function removeSelection(value) {
        let optionsList = document.getElementById('options-list');

        var filters = JSON.parse(sessionStorage.getItem('filters'));
        filters.depts = filters.depts.filter(function(val) { return val !== value; });

        var optionItems = optionsList.getElementsByTagName('li');
        for (var i = 0; i < optionItems.length; i++) {
            if (optionItems[i].getAttribute('data-value') === value) {
                optionItems[i].classList.remove('selected');
                break;
            }
        }

        sessionStorage.setItem('filters', JSON.stringify(filters));
        updateSelectedItems();
        applyFilters();
    }

    // application des filtres 
    function applyFilters() {
        // on supprime le message d'erreur s'il y en a
        var noResultElement = cardsContainer.querySelector('.no-result');
        if (noResultElement) {
            noResultElement.remove();
        }
    
        // on récupère les cartes
        var cards = cardsContainer.getElementsByClassName('card');
    
        // on récupère les filtres de sessionStorage
        var filters = JSON.parse(sessionStorage.getItem('filters'));
        
        var startDate = filters.date.start;
        var endDate = filters.date.end;
    
        // on applique les filtres sur les cartes
        for (var i = 0; i < cards.length; i++) {
            var card = cards[i];
            var cardDept = card.getAttribute('data-dept');
            var cardTarif = parseFloat(card.getAttribute('data-tarif'));
            var cardProprietaire = card.getAttribute('data-proprietaire');

            // on vérifie si la carte correspond aux filtres et on l'affiche ou non
            if(
                (filters.depts.length === 0 || filters.depts.includes(cardDept)) &&
                (filters.prix.min === null || cardTarif >= filters.prix.min) &&
                (filters.prix.max === null || cardTarif <= filters.prix.max) &&
                // on compare les communes sans prendre en compte la casse (le filters.communes a des masucules )
                (filters.communes.length === 0 || filters.communes.some(
                    commune => card.querySelector('.nomVille').textContent.toUpperCase().includes(commune.toUpperCase()))) &&
                (filters.proprietaires.length === 0 || filters.proprietaires.includes(cardProprietaire))
            )
            {
                card.classList.remove('d-none');
            } else {
                card.classList.add('d-none');
            }
        }
    
        // on filtre les cartes par date si les dates sont définies
        if (startDate && endDate) {
            fetch('/api/logementsDispo?startDate=' + startDate + '&endDate=' + endDate)
                .then(response => response.json())
                .then(data => {
                    let logementsData = data;
                    let logementsId = logementsData.map(logement => logement.id_logement);
    
                    for (var i = 0; i < cards.length; i++) {
                        let card = cards[i];
    
                        if (!logementsId.includes(parseInt(card.id))) {
                            card.classList.add('d-none');
                        }
                    }
    
                    // vérifier si tous les cards sont cachés après filtrage par date
                    checkForNoResults(cards);
                    logVisibleCards(cards);
                });
        } else {
            // vérifier si tous les cards sont cachés après filtrage initial
            checkForNoResults(cards);
            logVisibleCards(cards);
        }
    }
    
    // affichage du message d'erreur si aucun logement n'est trouvé
    function noResultMessage() {
        // on vérifie d'abord si le message n'est pas déjà affiché
        if (cardsContainer.querySelector('.no-result')) {
            return;
        }
    
        var noResult = document.createElement('div');
        noResult.classList.add('no-result');
        noResult.innerHTML = `<div id="not-found">
            <h2>Aucun logement trouvé</h2>
            <img src="/assets/imgs/alerts/notFound.jpeg" id="not-found-image" alt="Aucun résultat">
        </div>`;
    
        cardsContainer.appendChild(noResult);
    }
    
    // vérifier si tous les cards sont cachés après filtrage
    function checkForNoResults(cards) {
        var noResult = true;
        for (var i = 0; i < cards.length; i++) {
            if (!cards[i].classList.contains('d-none')) {
                noResult = false;
                break;
            }
        }
    
        if (noResult) {
            noResultMessage();
        }
    }
    
    // affichage du nombre de cards visibles
    function logVisibleCards(cards) {
        var visibleCards = 0;
        for (var i = 0; i < cards.length; i++) {
            if (!cards[i].classList.contains('d-none')) {
                visibleCards++;
            }
        }
        console.log('Nombre de cards visibles : ' + visibleCards);
    }
    
    // initialisation des filtres
    function setupFilters() {
        // filtre de departement
        var selectBox = document.getElementById('select-box');
        var dropdown = document.getElementById('dropdown');
        var searchInput = document.getElementById('search');
        var optionsList = document.getElementById('options-list');
        var selectedItems = document.getElementById('selected-items');
        
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

        // on affiche ou cache le dropdown
        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            
            // Toggle display
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
                dropdown.classList.add('fadeIn'); // Ajoute une classe pour l'animation d'entrée
            } else {
                dropdown.style.display = 'none';
                dropdown.classList.remove('fadeIn'); // Retire la classe pour l'animation de sortie
            }
        }
        
        // on filtre les departements en fonction de la recherche
        function filterOptions() {
            var filter = searchInput.value.toUpperCase();
            var li = optionsList.getElementsByTagName('li');

            for (var i = 0; i < li.length; i++) {
                var txtValue = li[i].textContent || li[i].innerText;
                li[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? '' : 'none';
            }
        }

        // on selectionne / deselectionne un departement
        function toggleSelection(target) {
            var value = target.getAttribute('data-value');

            var filters = JSON.parse(sessionStorage.getItem('filters'));
            if (!filters.depts.includes(value)) {
                filters.depts.push(value);
                target.classList.add('selected');
            } else {
                // on enleve le filtre departement du filtre
                let indexVal = filters.depts.indexOf(value);
                filters.depts.splice(indexVal, 1);

                target.classList.remove('selected');
            }
            
            sessionStorage.setItem('filters', JSON.stringify(filters));
            updateSelectedItems();
            applyFilters();
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
        priceInput.forEach(input =>{
            input.addEventListener("input", e =>{
                
                let minPrice = parseInt(priceInput[0].value),
                maxPrice = parseInt(priceInput[1].value);
                
                // session storage
                var filters = JSON.parse(sessionStorage.getItem('filters'));
                filters.prix.min = minPrice;
                filters.prix.max = maxPrice;

                sessionStorage.setItem('filters', JSON.stringify(filters));

                range.style.left = ((rangeInput[0].value - minPrice) / (maxPrice - minPrice)) * 100;
                // range.style.left = 0;
                range.style.right = 100 - ((rangeInput[1].value - minPrice) / (maxPrice - minPrice)) * 100;
                
                if((maxPrice - minPrice >= priceGap) && maxPrice <= rangeInput[1].max){
                    if(e.target.className === "input-min"){
                        rangeInput[0].value = minPrice;
                        range.style.left = ((rangeInput[0].value - minPrice) / (maxPrice - minPrice)) * 100 + "%";
                    } else{
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - ((rangeInput[1].value - minPrice) / (maxPrice - minPrice)) * 100 + "%";
                    }
                }
            });
        });

        // Écouteurs pour les inputs de range (le slider)
        rangeInput.forEach(input => {
            input.addEventListener("input", e => {
                let minVal = parseFloat(rangeInput[0].value);
                let maxVal = parseFloat(rangeInput[1].value);

                // session storage
                var filters = JSON.parse(sessionStorage.getItem('filters'));
                filters.prix.min = minVal;
                filters.prix.max = maxVal;
                sessionStorage.setItem('filters', JSON.stringify(filters));

                if(maxVal + priceGap > rangeInput[1].max) {
                    maxVal = parseFloat(rangeInput[1].max);
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

                // Mettre à jour le texte du bouton
                priceInput[0].value = minVal;
                priceInput[1].value = maxVal;

                // on met dans session storage
                var filters = JSON.parse(sessionStorage.getItem('filters'));
                filters.prix.min = minVal;
                filters.prix.max = maxVal;
                sessionStorage.setItem('filters', JSON.stringify(filters));

                // Mettre à jour la position du slider
                let leftPercent = ((rangeInput[0].value - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100;
                let rightPercent = 100 - ((rangeInput[1].value - rangeInput[1].min) / (rangeInput[1].max - rangeInput[1].min)) * 100;

                // Assurer que leftPercent et rightPercent sont toujours entre 0 et 100
                if (rightPercent < 0) {
                    rightPercent = 0;
                }
        
                // Mettre à jour la position du slider
                range.style.left = leftPercent + "%";
                range.style.right = rightPercent + "%";

                // Mettre à jour le texte du bouton
                document.getElementById('btnPrix').textContent = `Prix : ${minVal}€ - ${maxVal}€`;
                document.getElementById('btnPrix').setAttribute('data-min', minVal);
                document.getElementById('btnPrix').setAttribute('data-max', maxVal);
                applyFilters();
            });
        });

        // filtres commune
        var optionsListCommune = document.getElementById('options-list-commune');
        var selectedItemsCommune = document.getElementById('selected-items-commune');
        var searchInputCommune = document.getElementById('search-commune');
        var selectBoxCommune = document.getElementById('select-box-commune');
        var dropdownCommune = document.getElementById('dropdown-commune');

        
        // on rempli avec les communes 
        communes.forEach(function(commune) {
            var item = document.createElement('li');
            item.setAttribute('data-value', commune);
            item.innerText = commune;
            optionsListCommune.appendChild(item);
        });

        // on initialise les communes avec les filtres
        var filters = JSON.parse(sessionStorage.getItem('filters'));
        var communesFilter = filters.communes;
        // on pré-selection les communes
        communesFilter.forEach(function(value) {
            var item = optionsListCommune.querySelector('li[data-value="' + value + '"]');
            if (item) {
                item.classList.add('selected');
            }
        });

        updateSelectedItemsCommune();

        // on ajoute les écouteurs
        selectBoxCommune.addEventListener('click', function(event) {
            toggleDropdownCommune();
            event.stopPropagation();  
        });

        // on filtre les communes en fonction de la recherche
        searchInputCommune.addEventListener('keyup', function() {
            filterOptionsCommune();
        });

        // on selectionne / deselectionne une commune
        optionsListCommune.addEventListener('click', function(event) {
            var target = event.target;
            if (target.tagName === 'LI') {
                toggleSelectionCommune(target);
            }
        });

        // on cache le dropdown si on clique en dehors
        document.addEventListener('click', function(event) {
            if (!selectBoxCommune.contains(event.target) && !dropdownCommune.contains(event.target)) {
                dropdownCommune.style.display = 'none';
            }
        });

        // on permet de scroller horizontalement les communes selectionnées
        selectedItemsCommune.addEventListener('wheel', function(event) {
            if (event.deltaY !== 0) {
                event.preventDefault();
                selectedItemsCommune.scrollLeft += event.deltaY;
            }
        });

        // on affiche ou cache le dropdown
        function toggleDropdownCommune() {
            dropdownCommune.style.display = (dropdownCommune.style.display === 'none' || dropdownCommune.style.display === '') ? 'block' : 'none';
        }

        // on filtre les communes en fonction de la recherche
        function filterOptionsCommune() {
            var filter = searchInputCommune.value.toUpperCase();
            var li = optionsListCommune.getElementsByTagName('li');

            for (var i = 0; i < li.length; i++) {
                var txtValue = li[i].textContent || li[i].innerText;
                li[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? '' : 'none';
            }
        }

        // on selectionne / deselectionne une commune de la liste
        function toggleSelectionCommune(target) {
            var value = target.getAttribute('data-value');

            var filters = JSON.parse(sessionStorage.getItem('filters'));
            if (!filters.communes.includes(value)) {
                filters.communes.push(value);
                target.classList.add('selected');
            } else {
                // on enleve le filtre commune du filtre
                let indexVal = filters.communes.indexOf(value);
                filters.communes.splice(indexVal, 1);

                target.classList.remove('selected');
            }
            
            sessionStorage.setItem('filters', JSON.stringify(filters));
            updateSelectedItemsCommune();
            applyFilters();
        }

        // on met à jour les communes selectionnées dans l'input
        function updateSelectedItemsCommune() {
            let selectedItemsCommune = document.getElementById('selected-items-commune');
            let optionsListCommune = document.getElementById('options-list-commune');

            selectedItemsCommune.innerHTML = '';
            var filters = JSON.parse(sessionStorage.getItem('filters'));
            if(filters.communes.length > 0) {
                filters.communes.forEach(function(value) {
                    var item = document.createElement('div');
                    item.className = 'selected-item';
                    item.innerText = optionsListCommune.querySelector('li[data-value="' + value + '"]').innerText;

                    var removeIcon = document.createElement('span');
                    removeIcon.innerText = '✖';
                    removeIcon.addEventListener('click', function(event) {
                        removeSelectionCommune(value);
                        event.stopPropagation(); 
                    });

                    item.appendChild(removeIcon);
                    selectedItemsCommune.appendChild(item);
                });
            } else {
                selectedItemsCommune.innerText = 'Choisir';
            }
        }

        // on enleve une commune parmis celles selectionnées
        function removeSelectionCommune(value) {
            let optionsListCommune = document.getElementById('options-list-commune');

            var filters = JSON.parse(sessionStorage.getItem('filters'));
            filters.communes = filters.communes.filter(function(val) { return val !== value; });

            var optionItemsCommunes = optionsListCommune.getElementsByTagName('li');
            for (var i = 0; i < optionItemsCommunes.length; i++) {
                if (optionItemsCommunes[i].getAttribute('data-value') === value) {
                    optionItemsCommunes[i].classList.remove('selected');
                    break;
                }
            }

            sessionStorage.setItem('filters', JSON.stringify(filters));
            updateSelectedItemsCommune();
            applyFilters();
        }

        // filtre par propriétaire
        var optionsListProp = document.getElementById('options-list-prop');
        var selectedItemsProp = document.getElementById('selected-items-prop');
        var searchInputProp = document.getElementById('search-prop');
        var selectBoxProp = document.getElementById('select-box-prop');
        var dropdownProp = document.getElementById('dropdown-prop');

        // on rempli avec les proprietaires
        proprietaires.forEach(function(prop) {
            var item = document.createElement('li');
            item.setAttribute('data-value', prop.id);
            item.innerText = prop.nomPrenom;
            optionsListProp.appendChild(item);
        });

        // on initialise les proprietaires avec les filtres
        var filters = JSON.parse(sessionStorage.getItem('filters'));
        var proprietairesFilter = filters.proprietaires;
        // on pré-selection les proprietaires
        proprietairesFilter.forEach(function(value) {
            var item = optionsListProp.querySelector('li[data-value="' + value + '"]');
            if (item) {
                item.classList.add('selected');
            }
        });

        updateSelectedItemsProp();

        selectBoxProp.addEventListener('click', function(event) {
            toggleDropdownProp();
            event.stopPropagation();  
        });

        searchInputProp.addEventListener('keyup', function() {
            filterOptionsProp();
        });

        optionsListProp.addEventListener('click', function(event) {
            var target = event.target;
            if (target.tagName === 'LI') {
                toggleSelectionProp(target);
            }
        });

        document.addEventListener('click', function(event) {
            if (!selectBoxProp.contains(event.target) && !dropdownProp.contains(event.target)) {
                dropdownProp.style.display = 'none';
            }
        });

        // on permet de scroller horizontalement les proprietaires selectionnés
        selectedItemsProp.addEventListener('wheel', function(event) {
            if (event.deltaY !== 0) {
                event.preventDefault();
                selectedItemsProp.scrollLeft += event.deltaY;
            }
        });

        // on affiche ou cache le dropdown
        function toggleDropdownProp() {
            dropdownProp.style.display = (dropdownProp.style.display === 'none' || dropdownProp.style.display === '') ? 'block' : 'none';
        }

        // on filtre les proprietaires en foncion de la recherche
        function filterOptionsProp() { 
            var filter = searchInputProp.value.toUpperCase();
            var li = optionsListProp.getElementsByTagName('li');

            for (var i = 0; i < li.length; i++) {
                var txtValue = li[i].textContent || li[i].innerText;
                li[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? '' : 'none';
            }
        }

        // on selectionne / deselectionne un proprietaire
        function toggleSelectionProp(target) {
            var value = target.getAttribute('data-value');

            var filters = JSON.parse(sessionStorage.getItem('filters'));
            if (!filters.proprietaires.includes(value)) {
                filters.proprietaires.push(value);
                target.classList.add('selected');
            } else {
                // on enleve le filtre proprietaire du filtre
                let indexVal = filters.proprietaires.indexOf(value);
                filters.proprietaires.splice(indexVal, 1);

                target.classList.remove('selected');
            }
            
            sessionStorage.setItem('filters', JSON.stringify(filters));
            updateSelectedItemsProp();
            applyFilters();
        }

        // on met à jour les proprietaires selectionnés
        function updateSelectedItemsProp() {
            let selectedItemsProp = document.getElementById('selected-items-prop');
            let optionsListProp = document.getElementById('options-list-prop');

            selectedItemsProp.innerHTML = '';
            var filters = JSON.parse(sessionStorage.getItem('filters'));
            if(filters.proprietaires.length > 0) {
                filters.proprietaires.forEach(function(value) {
                    var item = document.createElement('div');
                    item.className = 'selected-item';
                    item.innerText = optionsListProp.querySelector('li[data-value="' + value + '"]').innerText;

                    var removeIcon = document.createElement('span');
                    removeIcon.innerText = '✖';
                    removeIcon.addEventListener('click', function(event) {
                        removeSelectionProp(value);
                        event.stopPropagation(); 
                    });

                    item.appendChild(removeIcon);
                    selectedItemsProp.appendChild(item);
                });
            } else {
                selectedItemsProp.innerText = 'Choisir';
            }
        }

        // on enleve un propriétaire parmis ceux selecitonnés
        function removeSelectionProp(value) {
            let optionsListProp = document.getElementById('options-list-prop');

            var filters = JSON.parse(sessionStorage.getItem('filters'));
            filters.proprietaires = filters.proprietaires.filter(function(val) { return val !== value; });

            var optionItemsProp = optionsListProp.getElementsByTagName('li');
            for (var i = 0; i < optionItemsProp.length; i++) {
                if (optionItemsProp[i].getAttribute('data-value') === value) {
                    optionItemsProp[i].classList.remove('selected');
                    break;
                }
            }

            sessionStorage.setItem('filters', JSON.stringify(filters));
            updateSelectedItemsProp();
            applyFilters();
        }
    }

    function setupSorting() {
        // Configure le bouton pour basculer entre tri croissant et décroissant
        document.getElementById('sortToggle').addEventListener('click', function() {
            isAscending = !isAscending; // Inverse l'état du tri
            this.textContent = isAscending ? 'Trier par prix décroissant' : 'Trier par prix croissant';
            // on adapte le session storage
            var filters = JSON.parse(sessionStorage.getItem('filters'));
            filters.tri = isAscending ? 'asc' : 'desc';
            sessionStorage.setItem('filters', JSON.stringify(filters));

            sortLogements(); 
        });

        document.getElementById('sortToggle').textContent = isAscending ? 'Trier par prix décroissant' : 'Trier par prix croissant';
    }

    // Trie les logements par prix
    function sortLogements() {
        let sortedLogements = Array.from(cardsContainer.children);
        sortedLogements.sort((a, b) => {
            let prixA = parseFloat(a.getAttribute('data-tarif'));
            let prixB = parseFloat(b.getAttribute('data-tarif'));
            return isAscending ? prixA - prixB : prixB - prixA;
        });

        // on réorganise les cards
        cardsContainer.innerHTML = '';
        sortedLogements.forEach(logement => {
            cardsContainer.appendChild(logement);
        });
    }

    // on ajuste le margin top du container des cards, cela permet de s'adapter à la taille 
    // de la fenetre meme quand elle change de taille après le chargement du css 
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
});