<?php
include_once 'Views/Back/composants/header.php';
include_once 'Views/Back/composants/head.php';
?>
<body>
    <section id="test">
        <div>
            <h1> Vos tokens </h1>
            <div id="zonetoken"></div>
        </div>
        <div>
            <h3>Création de Tokens</h3>
            <h5>Cliquez sur le bouton ci-dessous pour génerer un token</h5>
            <button id="generateToken">Générer un token</button>
        </div>
    </section>
</body>
<?php include_once 'Views/Back/composants/footer.php' ?>