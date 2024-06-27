<html>
<!-- <link rel="stylesheet" type="text/css" href="/assets/SCSS/Back/footer.css"/>
<script type="text/javascript" src="/assets/JS/Back/listeReservations.js"></script> -->

<?php
    include_once 'Views/Back/composants/header.php';
    include_once 'Views/Back/composants/head.php';
?>

<body>
    <section id="msgBienvenue">
        <h1 id="bonjour">Bonjour,</h1>
        <h2 id="nbReservationsEnCours">Vous avez 0 réservations en cours</h2>
        <a href="/reservations/abonnements/liste" id="btniCal">Gérer mes abonnements iCal</a>
    </section>

    <!-- Boutons pour trier les réservations affichées par état -->
    <section id="etatResa">
        <button id="enCours">En cours (0)</button>
        <button id="aVenir">A venir (0)</button>
        <button id="passe">Passé (0)</button>
        <button id="tout" class="ongletSelect">Tout (0)</button>
    </section>
    <span id="barreEtat"></span>

    <!-- Onglets pour trier les réservations affichées par état -->
    <section id="ongletFiltres">
        <h1>Filtres</h1>
        <span id="barreFiltres"></span>
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
    <section id="contentReservations">
        <div id="listeReservations">
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
                </tbody>
            </table>
            <h1 id="noReservations" class="d-none">Aucune réservation trouvée</h1>
        </div>

        <!-- <h1 id="voirPlus">Voir plus</h1> -->
        
    </section>
    
</body>
<?php include 'Views/Back/composants/footer.php'; ?>
</html>