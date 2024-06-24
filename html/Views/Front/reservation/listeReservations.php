<html>
<!-- <link rel="stylesheet" type="text/css" href="/assets/SCSS/Back/footer.css"/>
<script type="text/javascript" src="/assets/JS/Back/listeReservations.js"></script> -->

<?php
    include_once 'Views/Front/composants/header.php';
    include_once 'Views/Front/composants/head.php';
?>

<body>
    <section id="msgBienvenue">
        <h1 id="bonjour">Bonjour,</h1>
        <h2 id="nbReservationsEnCours">vous avez 0 réservations en cours</h2>
    </section>

    <!-- Boutons pour trier les réservations affichées par état -->
    <section id="etatResa">
        <button id="enCours">En cours (0)</button>
        <button id="aVenir">A venir (0)</button>
        <button id="passe">Passé (0)</button>
        <button id="tout" class="ongletSelect">Tout (0)</button>
    </section>
    <span id="barreEtat"></span>
    

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
                        <th>Propriétaire</th>
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
<?php include 'Views/Front/composants/footer.php'; ?>
</html>