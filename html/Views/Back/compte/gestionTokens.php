<?php
include_once 'Views/Back/composants/header.php';
include_once 'Views/Back/composants/head.php';
?>
<body>
    <section>
        <div>
            <h3>Création de Tokens</h3>
            <h4>Cliquez sur le bouton ci-dessous pour génerer un token</h4>
            <button id="generateToken">Générer un token</button>
        </div>
        <div>
            <h1> Vos tokens </h1>
            <div id="zonetoken"></div>
        </div>

    </section>
</body>
<?php include_once 'Views/Back/composants/footer.php' ?>