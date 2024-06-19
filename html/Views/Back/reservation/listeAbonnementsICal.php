<?php
    include_once("Views/Back/composants/header.php");
    include_once("Views/Back/composants/head.php");
?>
<body>
    <h1>Liste des abonnements iCal</h1>
    <table id="tableListeLogements">
        <thead>
            <tr>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Logements</th>
                <th>Url</th>
            </tr>
        </thead>
        <tbody id="tbodyListeLogements">
        </tbody>
    </table>
    
    <!-- modale affichant la liste des logements liés à l'abonnement -->
    <div id="modalListeLogements" class="d-none">
        <div id="logementsPopupContent">
            <h4>Liste des logements liés à l'abonnement</h4>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Adresse</th>
                        <th>Code postal</th>
                        <th>Ville</th>
                        <th>Pays</th>
                    </tr>
                </thead>
                <tbody id="logementsPopupTbody">
                </tbody>
            </table>
        </div>
    </div>
</body>