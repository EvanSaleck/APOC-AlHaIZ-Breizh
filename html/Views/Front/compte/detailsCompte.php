<?php
include_once 'Views/Front/composants/navbar.php';
include_once 'Views/Front/composants/header.php';
include_once 'Views/Front/composants/head.php';
?>


<body>
  <div class="compte">
    <div class="détailEtPhoto">
      <div class="divPP">
        <img class="imgProfil" src="" alt="">
      </div>
      <h1>Détails du compte</h1>
    </div>
    <div>
      <div class="infoCo">
        <h2>Informations de connexion</h2>
        <div class="divPseudo">
          <h3>Identifiant :</h3>
          <p class="pseudo"></p>
        </div>
        <div class="divEmail">
          <h3>Email :</h3>
          <p class="email"></p>
        </div>

        <div class="d-none" id="zonemodif">
          <h3>Ancien mot de passe :</h3>
          <input class="oldPwd" type="password"/>
          <h3>Tapez mot de passe :</h3>
          <input class="newPwd" type="password"/>
          <h3>Confirmation mot de passe :</h3>
          <input class="confPwd" type="password"/>
        </div>

        <button class="mdp">Modifier Mot de passe</button>
        <button class="annul d-none">Annuler</button>
      </div>
      <div class="infoPer">
        <h2>Informations personnelles</h2>
        <div>
          <div class="divNom">
            <h3>Nom :</h3>
            <p class="nom"></p>
          </div>
          <div class="divPrenom">
            <h3>Prénom :</h3>
            <p class="prenom"></p>
          </div>
          <div class="divCivilite">
            <h3>Civilité :</h3>
            <p class="civilite"></p>
          </div>
          <div class="divAdresse">
            <h3>Adresse de facturation :</h3>
            <p class="rue"></p>
            <p class="codePostal"></p>
            <p class="ville"></p>
            <p class="pays"></p>
          </div>
        </div>
      </div>

    </div>
    <div>

      <button class="update">Modifier le profil</button>
    </div>
  </div>
</body>
<?php include_once 'Views/Front/composants/footer.php' ?>