<?php
    include_once("Views/Back/composants/head.php");
?>

<body>
    <section>
        <div>
            <img src="/assets/imgs/logo.webp" id="logoAssoHeaderDesktop" alt="Logo">
            <p id="titreHeader">AlHaIZ Breizh</p>
        </div>
        <h1>Connexion propriétaire</h1>
            <div class="form-group">
                <label for="pseudo">Adresse email ou Pseudonyme</label>
                <input type="pseudo" name="pseudo" id="pseudo" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button onclick="Connexion()">Se connecter</button>
    </section>
</body>