<html>
<!-- <link rel="stylesheet" type="text/css" href="/assets/SCSS/Back/footer.css"/>
<script type="text/javascript" src="/assets/JS/Back/listeReservations.js"></script> -->

<?php
    include_once 'Views/Back/composants/header.php';
    include_once 'Views/Back/composants/head.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<body>
    <section id="msgBienvenue">
        <h1 id="bonjour">Bonjour,</h1>
        <h1> Voici la liste de vos logements </h1>

        <a href="/back/logement/new" id="btnNewLogement">Créer un logement</a>
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
                </tbody>
            </table>
        </div>
    </section>
    
</body>
<?php include 'Views/Back/composants/footer.php'; ?>
</html>
