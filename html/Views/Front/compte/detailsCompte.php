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
    <div class="infoCo">
        <h2>Informations de connexion</h2>
        <div class="divPseudo">
          <h3>Identifiant :</h3>
          <input class="pseudo" type="text" disabled/>
        </div>
        <div class="divEmail">
          <h3>Email :</h3>
          <input class="email" type="email" disabled/>
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
            <input class="nom" type="text" disabled/>
          </div>
          <div class="divPrenom">
            <h3>Prénom :</h3>
            <input class="prenom" type="text" disabled/>
          </div>
          <div class="divCivilite">
            <h3>Civilité :</h3>
            <select class="civilite" disabled>
              <option value="Mr">Monsieur</option>
              <option value="Mme">Madame</option>
              <option value="Non spécifié">Non spécifié</option>
            </select>
          </div>
          <div class="divAdresse">
            <h3>Adresse de facturation :</h3>
            <input class="rue" type="text" disabled/>
            <input class="codePostal" type="number" disabled/>
            <input class="ville" type="text" disabled/>
            <input class="pays" type="text" disabled/>
          </div>
        </div>
      </div>

    </div>
    <div>
      <button class="update">Modifier le profil</button>
      <button class="save d-none">Enregistrer</button>
      <button class="annul d-none" id="annulmodif">Annuler</button>
    </div>
  </div>
</body>
<?php include_once 'Views/Front/composants/footer.php' ?>