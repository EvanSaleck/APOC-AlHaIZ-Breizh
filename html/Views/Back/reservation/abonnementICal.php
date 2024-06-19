<?php
    include_once("Views/Back/composants/header.php");
    include_once("Views/Back/composants/head.php");
?>
<body>
    <h1 id="titre">S'abonner au format iCal</h1>
    <a href="/reservations/abonnements/liste">Liste des abonnements iCal</a>
    <form name="formICal" id="formICal" method="POST">
        <label for="dateDebut">Date de début</label>
        <input type="date" name="dateDebut" id="dateDebut">
        <span class="messageError" id="errorDateDebut"></span>

        <label for="dateFin">Date de fin</label>
        <input type="date" name="dateFin" id="dateFin">
        <span class="messageError" id="errorDateFin"></span>

        <label for="listeLogements" id="listeLogementsLabel">Liste des logements</label>
        <span class="messageError" id="errorListeLogements"></span>
        <div id="listeLogements"></div>

        <input id="submit" type="submit" value="Récupérer l'url pour m'abonner">    
    </form>
</body>
