<html>
<!-- <link rel="stylesheet" type="text/css" href="/assets/SCSS/Back/footer.css"/>
<script type="text/javascript" src="/assets/JS/Back/listeReservations.js"></script> -->

<?php
    include_once 'Views/Back/composants/header.php';
    include_once 'Views/Back/composants/head.php';
?>

<body>
    <section id="msgBienvenue">
        <h1>Bonjour Jean,</h1>
        <h1> Voici la liste de vos logements </h1>

    </section>


    <!-- Onglets pour trier les réservations affichées par état -->
    <section id="ongletFiltres">
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

        <!-- Bouton pour trier les réservations affichées par date de réservation
         (pris la date d'arrivée comme point de tri) -->
        <div id="croissantDecroissant">
            <img src="/assets/imgs/mobile/Chevron2.svg">
            <button id="croissDecroiss">Trier par date de réservations (Croissant)</button>
        </div>
    </section>

    

    <!-- Table d'affichage des réservations -->
    <section id="sectionLogements">
        <div id="listeLogements">
            <table>
                <thead>
                    <tr>
                        <th>Photo principale</th>
                        <th>Titre logement</th>
                        <th>Accroche</th>
                        <th>En ligne / Hors ligne</th>
                        <th>Modifier le logement</th>
                    </tr>
                </thead>

                <tbody id="ListeLogements">
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
        </div>

        <!-- <h1 id="voirPlus">Voir plus</h1> -->
        
    </section>
    
</body>
<?php include 'Views/Back/composants/footer.php'; ?>
</html>