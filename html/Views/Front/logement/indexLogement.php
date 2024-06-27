<?php

 include_once 'Views/Front/composants/navbar.php';
 include_once 'Views/Front/composants/card.php';
 include_once 'Views/Front/composants/header.php';
 include_once 'Views/Front/composants/head.php';
 ?>
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="/assets/SCSS/Front/datePicker.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<body>
    <div id="headerAccueilMobile">
        <img src="/assets/imgs/logo.webp" id="logoAssoMobile" alt="Logo de l'association">
        <button id="buttonfiltresMobile">
            <img src="/assets/imgs/mobile/Menu.svg" alt="Logo menu">
        </button>
    </div>
    <div id="imageAccueil"></div>

    <div id="filtres">
        <div class="filtreContainer multiselect-container">
            <label>Par département</label>
            <div class="select-box" id="select-box">
                <div class="selected-items" id="selected-items">Choisir</div>
                <div class="arrow">&#9660;</div>
            </div>
            <div class="dropdown" id="dropdown">
                <input type="text" id="search" class="searchDept" placeholder="Rechercher...">
                <ul id="options-list">
                    <li data-value="22">Côtes d’Armor</li>
                    <li data-value="29">Finistère</li>
                    <li data-value="35">Ille-et-Vilaine</li>
                    <li data-value="56">Morbihan</li>
                </ul>
            </div>
        </div>

        <div id="filtrePrixContainer" class="filtreContainer">
            <div id="prixFiltresContainer">
                <label>Par tranche de prix</label>
                <button id="btnPrix"><span id="prixMin"></span> - <span id="prixMax"></span> €/nuit</button>
                <div id="wrapper">
                    <div class="price-input">
                        <div class="field">
                            <span>Min</span>
                            <input type="number" class="input-min">
                        </div>
                        <div class="separator">-</div>
                        <div class="field">
                            <span>Max</span>
                            <input type="number" class="input-max">
                        </div>
                    </div>
                    <div class="slider">
                        <div class="progress"></div>
                    </div>
                    <div class="range-input">
                        <input type="range" class="range-min" step="10">
                        <input type="range" class="range-max" step="10">
                    </div>
                </div>
            </div>
        </div>

        <div class="filtreContainer">
            <label for="rangePicker">Par date</label>
            <input type="text" id="rangePicker" placeholder="Sélectionnez une période de date">
        </div>

        <div class="filtreContainer multiselect-container">
            <label>Par commune</label>
            <div class="select-box" id="select-box-commune">
                <div class="selected-items" id="selected-items-commune">Choisir</div>
                <div class="arrow">&#9660;</div>
            </div>
            <div class="dropdown" id="dropdown-commune">
                <input type="text" id="search-commune" placeholder="Rechercher...">
                <ul id="options-list-commune"></ul>
            </div>
        </div>

        <div class="filtreContainer multiselect-container">
            <label>Par propriétaire</label>
            <div class="select-box" id="select-box-prop">
                <div class="selected-items" id="selected-items-prop">Choisir</div>
                <div class="arrow">&#9660;</div>
            </div>
            <div class="dropdown" id="dropdown-prop">
                <input type="text" id="search-prop" placeholder="Rechercher...">
                <ul id="options-list-prop"></ul>
            </div>
        </div>

        <div id="sortingContainer" class="filtreContainer">
            <label for="tri">Tri</label>
            <button id="sortToggle">Trier par prix croissant</button>
        </div>
    </div>
    <div id="cardsContainer"></div>
    <div id="ongletFiltres">
        
        <!-- <h1>Filtres</h1>
        <span id="barreFiltresMobiles"></span>
        <div>
            <label for="parCommune">Commune</label>
            <input type="text" name="parCommune" id="parCommune">
        </div>
        <div>
            <label for="parDepartement">Département</label>
            <input type="text" name="parDepartement" id="parDepartement">
        </div>
        <div>
            <label for="parProprietaire">Propriétaire</label>
            <input type="text" name="parProprietaire" id="parProprietaire">
        </div>
        <div>
            <label for="parDateArrivee">Date d'arrivée</label>
            <input type="date" name="parDateArrivee" id="parDateArrivee">
        </div>
        <div>
            <label for="parDateDepart">Date de départ</label>
            <input type="date" name="parDateDepart" id="parDateDepart">
        </div>
        <div>
            <label for="parTypeLogement">Type de logement</label>
            <input type="text" name="parTypeLogement" id="parTypeLogement">
        </div>
        <div>
            <p>Prix</p>
            <div id="prixOngletFiltreMobile">
                <div id="prixParMinDiv">
                    <label for="parPrixMin">Min</label>
                    <input type="text" name="parPrixMin" id="parPrixMin">
                </div>
                <div id="prixParMaxDiv">
                    <label for="parPrixMax">Max</label>
                    <input type="text" name="parPrixMax" id="parPrixMax">
                </div>
            </div>
        </div> -->
    </div>
</body>
<?php 
    include_once 'Views/Front/composants/footer.php' 
?>
</html>