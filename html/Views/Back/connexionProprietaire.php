<?php
    include_once("Views/Back/composants/head.php");
?>

<body>
    <section>
        <div id="logo">
            <img src="/assets/imgs/logo.webp" id="logoAssoHeaderDesktop" alt="Logo">
            <p id="titreHeader">ALHaIZ Breizh</p>
        </div>
        <h1>Connexion propriétaire</h1>
        <div class="form-group">
            <label for="pseudo">Adresse email ou Pseudonyme</label>
            <input type="pseudo" name="pseudo" id="pseudo" placeholder="Jean.valJean@gmail.com" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="********" required>
        </div>
        <button id="btnConnexion">Se connecter</button>
    </section>
</body>


<script type="module" src="/assets/js/utils.js"></script>