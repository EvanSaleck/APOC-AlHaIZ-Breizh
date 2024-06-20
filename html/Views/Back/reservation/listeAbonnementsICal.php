<?php
    include_once("Views/Back/composants/header.php");
    include_once("Views/Back/composants/head.php");
?>
<body>
    <h1>Liste des abonnements iCal</h1>
    <div id="bodyContent">
        <div id="divButton">
            <a href="/reservations/abonnements/iCal/new" id="lienNewAbo">Créer un nouvel abonnement iCal</a>
        </div>
        <table id="tableListeLogements">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Logements</th>
                    <th>Copier l'url</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody id="tbodyListeLogements">
            </tbody>
        </table>
    </div>
</body>