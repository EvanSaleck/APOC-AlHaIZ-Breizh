<?php
    include_once("Views/Back/composants/header.php");
    include_once("Views/Back/composants/head.php");
?>
<body>
    <h1>Liste des abonnements iCal</h1>
    <a href="/reservations/abonnements/iCal/new" class="btn btn-primary">Nouvel abonnement iCal</a>
    <table id="tableListeLogements">
        <thead>
            <tr>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Logements</th>
                <th>Url</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody id="tbodyListeLogements">
        </tbody>
    </table>
</body>