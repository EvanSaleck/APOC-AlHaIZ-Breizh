<html>
<link rel="stylesheet" type="text/css" href="../../../assets/SCSS/footer.css"/>

<?php
    // include 'Views/Front/composants/header.php';
    // include 'Views/Back/composants/navbar.php';
    include_once 'Views/Front/composants/head.php';
?>

<body>
    

    <div id="msgBienvenue">
        <h1>Bonjour Jean,</h1>
        <h2>vous avez 3 réservations en cours</h2>
    </div>

    <div id="etatResa">
        <button id="enCours" class="ongletSelect">En cours (3)</button>
        <button id="aVenir">A venir (3)</button>
        <button id="passe">Passé (5)</button>
        <button id="tout">Tout</button>
    </div>
    <span id="barreEtat"></span>

    <div id="ongletFiltres">
        <h1>Filtres</h1>
        <span id="barreFiltresProprio"></span>
        <div>
            <label for="parLogement">Logement</label>
            <input type="text" name="parLogement" id="parLogement">
        </div>
        <div>
            <label for="parDateArr">Date d'arrivée</label>
            <input type="date" name="parDateArr" id="parDateArr">
        </div>
        <div>
            <label for="parDateDep">Date de départ</label>
            <input type="date" name="parDateDep" id="parDateDep">
        </div>
        <div>
            <label for="parTarif">Tarif global</label>
            <input type="text" name="parTarif" id="parTarif">
        </div>
        <div>
            <label for="parClient">Client</label>
            <input type="text" name="parClient" id="parClient">
        </div>
    </div>


    <div id="croissantDecroissant">
        <img src="/assets/imgs/mobile/Chevron2.svg">
        <button id="croissDecroiss">Trier par date de réservations (Croissant)</button>
    </div>


    <div id="listeResa">
        <table>
            <thead>
                <tr>
                    <th>Logement</th>
                    <th>Date d'arrivée</th>
                    <th>Date de départ</th>
                    <th>Tarif global</th>
                    <th>Client</th>
                </tr>
            </thead>

            <tbody id="tableContent">
                <tr>
                    <td>Maisonette bord de plage</td>
                    <td>12/09/2024</td>
                    <td>25/13/2024</td>
                    <td>563€</td>
                    <td>J.Valjean</td>
                </tr>
                <tr>
                    <td>Maisonette bord de plage</td>
                    <td>12/09/2024</td>
                    <td>25/13/2024</td>
                    <td>563€</td>
                    <td>J.Valjean</td>
                </tr>
                <tr>
                    <td>Maisonette bord de plage</td>
                    <td>12/09/2024</td>
                    <td>25/13/2024</td>
                    <td>563€</td>
                    <td>J.Valjean</td>
                </tr>
            </tbody>


        </table>

        <h1 id="voirPlus">Voir plus</h1>

    </div>

    <?php include 'Views/Back/composants/footer.php'; ?>
</body>

</html>