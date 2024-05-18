<?php
//  include 'Views/Front/composants/header.php';
 include_once 'Views/Front/composants/navbar.php';
 include_once 'Views/Front/composants/card.php';
 include_once 'Views/Front/composants/head.php';

 ?>

<body>
    <div id="headerAccueilMobile">
        <img src="/assets/imgs/logo.png" id="logoAssoMobile" alt="Logo de l'association">
        <button id="buttonfiltresMobile">
            <img src="/assets/imgs/mobile/Menu.svg" alt="Logo menu">
        </button>
    </div>

    <div id="cardsContainer">

    </div>

    <div id="ongletFiltres">
        <h1>Filtres</h1>
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
        </div>
    </div>    
</body>
</html>