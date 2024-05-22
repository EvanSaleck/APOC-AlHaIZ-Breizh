<?php
//  include_once 'Views/Front/composants/navbar.php';
 include_once 'Views/Front/composants/card.php';
 include_once 'Views/Front/composants/header.php';
//  include_once 'Views/Front/composants/footer.php';
 include_once 'Views/Front/composants/head.php';
 ?>

<body>

    <div id="headerAccueilMobile">
        <img src="/assets/imgs/logo.png" id="logoAssoMobile" alt="Logo de l'association">
        <button id="buttonfiltresMobile">
            <img src="/assets/imgs/mobile/Menu.svg" alt="Logo menu">
        </button>
    </div>

    <div id="cardsContainer"></div>

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

    <div class="modal-content">
        <span class="fermer">&times;</span>   
        <h2>Inscription</h2>
        <div id="connexionForm">
            <label for="nom">Nom :  
            <input type="nom" id="nom" name="nom" placeholder="Valjean" required></label>
            <label for="prenom">Prénom :
            <input type="prenom" id="prenom" name="prenom" placeholder="Jean" required></label>
            <label for="pseudo">Pseudonyme :
            <input type="pseudo" id="pseudo" name="pseudo" placeholder="ValJean" required></label>
            <label for="civilite">Civilité :
            <select name="civilite" id="civilite" required>
                <option value="Mr.">Monsieur</option>
                <option value="Mme">Madame</option>
                <option value="Non spécifié">Non spécifié</option>
            </select></label>
            <label for="email">E-mail :
            <input type="email" id="email" name="email" placeholder="Jean.valjean@gmail.com" required></label>
            <label for="password">Mot de passe
            <input type="password" id="password" name="password" placeholder="********" required></label>
            <label for="verifpassword">Confirmer le mot de passe
            <input type="verifpassword" id="verifpassword" name="verifpassword" placeholder="********" required></label>

            <label for="cgu">En cochant cette case, je confirme avoir lu et accepté les Conditions Générales d'Utilisation d'ALHaIZ Breizh. Je comprends que ces conditions régissent l'utilisation des services fournis et j'accepte de les respecter.
            <input type="checkbox" id="cgu" name="cgu" required></label>

            <label for="cgu">En cochant cette case, je reconnais avoir lu et accepté les Conditions Générales de Vente d'ALHaIZ Breizh. Je comprends que ces conditions définissent les modalités de vente entre ALHaIZ Breizh et moi-même et m'engage à les respecter.
            <input type="checkbox" id="cgv" name="cgv" required></label>
            <button id="Connexion" onclick="Inscription()">S'inscrire</button>
        </div>
        <p>Déjà un compte ?<span id="inscription" onclick="CreateConnexionModal()">Connectez vous</span></p>
    </div>
</body>
</html>