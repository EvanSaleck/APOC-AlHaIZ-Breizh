import * as utils from "../utils.js";

let currentUser = null;

addEventListener("DOMContentLoaded", () => {
  GetConnected();
  SetModalAndProfilePicture();
  AddListeners();
});


// Ajout des écouteurs d'événements
function AddListeners() {
  let compte = document.getElementById("Compte");
  compte.addEventListener("click", () => {
    if (currentUser === null) {
      ShowModalConnexion();
    } else {
      ShowModalProfile();
    }
  });

  let modale = document.getElementById("Bubble");

}

// Récupération de l'utilisateur connecté
function GetConnected() {
  if (sessionStorage.getItem("Proprio") != null) {
    let user = JSON.parse(sessionStorage.getItem('Proprio'));
    console.log(user);
    currentUser = user;
  }
}

// Affichage de la photo de profil dans le header 
function SetModalAndProfilePicture() { 
    let compte = document.getElementById("Compte");
    if (currentUser === undefined || currentUser === null) {
      compte.style.backgroundImage = "url('/assets/imgs/person-fill.svg')"; 
    } else if (currentUser && currentUser.photo_profil) { 
      compte.style.backgroundImage = "url('" + currentUser.photo_profil + "')";
    }
}

// affichage de la modale de connexion avec les boutons de connexion et d'inscription
function ShowModalConnexion() {
  let modal = document.getElementById("Bulle");
  let profile = document.getElementById("Profil");
  profile.innerHTML = `<p>S'inscrire</p><svg width="35" height="35" viewBox="0 0 55 46" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M13.0951 34.4512C15.673 38.6534 19.553 41.8984 24.1448 43.6925C28.7365 45.4867 33.7887 45.7318 38.5326 44.3905C43.2764 43.0493 47.4523 40.1951 50.4249 36.2622C53.3974 32.3294 55.0038 27.5331 54.9998 22.6033C54.9957 17.6735 53.3813 12.8799 50.4023 8.95193C47.4233 5.02398 43.2427 2.17667 38.4967 0.843236C33.7506 -0.4902 28.6988 -0.236768 24.11 1.56497C19.5212 3.36671 15.6466 6.61812 13.0757 10.8245L16.8626 13.1391C18.9292 9.75798 22.0436 7.14447 25.7321 5.69622C29.4206 4.24797 33.4812 4.04426 37.2962 5.11609C41.1111 6.18791 44.4715 8.47659 46.866 11.6339C49.2606 14.7912 50.5582 18.6443 50.5615 22.607C50.5647 26.5696 49.2735 30.4248 46.8841 33.5861C44.4948 36.7473 41.1382 39.0416 37.325 40.1197C33.5119 41.1978 29.4509 41.0008 25.76 39.5586C22.0692 38.1165 18.9504 35.5081 16.8783 32.1304L13.0951 34.4512Z" fill="black"/>
  <path d="M2 20.4756C1.17157 20.4756 0.5 21.1472 0.5 21.9756C0.5 22.804 1.17157 23.4756 2 23.4756L2 20.4756ZM41.8411 23.0362C42.4269 22.4505 42.4269 21.5007 41.8411 20.9149L32.2952 11.369C31.7094 10.7832 30.7597 10.7832 30.1739 11.369C29.5881 11.9548 29.5881 12.9045 30.1739 13.4903L38.6592 21.9756L30.1739 30.4609C29.5881 31.0467 29.5881 31.9964 30.1739 32.5822C30.7597 33.168 31.7094 33.168 32.2952 32.5822L41.8411 23.0362ZM2 23.4756L40.7805 23.4756V20.4756L2 20.4756L2 23.4756Z" fill="black"/>
  </svg>`;
  // profile.setAttribute("onclick", "CreateInscriptionModal()");
  let connexion = document.getElementById("Connexion");
  connexion.innerHTML = `<p>Se Connecter</p><svg width="35" height="35" viewBox="0 0 55 46" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M13.0951 34.4512C15.673 38.6534 19.553 41.8984 24.1448 43.6925C28.7365 45.4867 33.7887 45.7318 38.5326 44.3905C43.2764 43.0493 47.4523 40.1951 50.4249 36.2622C53.3974 32.3294 55.0038 27.5331 54.9998 22.6033C54.9957 17.6735 53.3813 12.8799 50.4023 8.95193C47.4233 5.02398 43.2427 2.17667 38.4967 0.843236C33.7506 -0.4902 28.6988 -0.236768 24.11 1.56497C19.5212 3.36671 15.6466 6.61812 13.0757 10.8245L16.8626 13.1391C18.9292 9.75798 22.0436 7.14447 25.7321 5.69622C29.4206 4.24797 33.4812 4.04426 37.2962 5.11609C41.1111 6.18791 44.4715 8.47659 46.866 11.6339C49.2606 14.7912 50.5582 18.6443 50.5615 22.607C50.5647 26.5696 49.2735 30.4248 46.8841 33.5861C44.4948 36.7473 41.1382 39.0416 37.325 40.1197C33.5119 41.1978 29.4509 41.0008 25.76 39.5586C22.0692 38.1165 18.9504 35.5081 16.8783 32.1304L13.0951 34.4512Z" fill="black"/>
    <path d="M2 20.4756C1.17157 20.4756 0.5 21.1472 0.5 21.9756C0.5 22.804 1.17157 23.4756 2 23.4756L2 20.4756ZM41.8411 23.0362C42.4269 22.4505 42.4269 21.5007 41.8411 20.9149L32.2952 11.369C31.7094 10.7832 30.7597 10.7832 30.1739 11.369C29.5881 11.9548 29.5881 12.9045 30.1739 13.4903L38.6592 21.9756L30.1739 30.4609C29.5881 31.0467 29.5881 31.9964 30.1739 32.5822C30.7597 33.168 31.7094 33.168 32.2952 32.5822L41.8411 23.0362ZM2 23.4756L40.7805 23.4756V20.4756L2 20.4756L2 23.4756Z" fill="black"/>
    </svg>`;
  
  connexion.addEventListener("click", () => {
    utils.CreateConnexionModal();
  });

  modal.classList.remove("d-none");
}


// affichage de la modale de profil
function ShowModalProfile() {
  let modal = document.getElementById("Bulle");
  let profile = document.getElementById("Profil");
  profile.innerHTML = `<p>Mon Compte</p><svg width="35" height="35" viewBox="0 0 45 44" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M22.5 24.75C29.332 24.75 34.875 19.207 34.875 12.375C34.875 5.54297 29.332 0 22.5 0C15.668 0 10.125 5.54297 10.125 12.375C10.125 19.207 15.668 24.75 22.5 24.75ZM33.5 27.5H28.7648C26.857 28.3766 24.7344 28.875 22.5 28.875C20.2656 28.875 18.1516 28.3766 16.2352 27.5H11.5C5.42422 27.5 0.5 32.4242 0.5 38.5V39.875C0.5 42.1523 2.34766 44 4.625 44H40.375C42.6523 44 44.5 42.1523 44.5 39.875V38.5C44.5 32.4242 39.5758 27.5 33.5 27.5Z" fill="black"/>
  </svg>`;
  profile.addEventListener('click', function() {
    location.href = "/back/detailsCompte";
  });
  
  let connexion = document.getElementById("btnConnexion");

  connexion.innerHTML = `<p>Se Déconnecter</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>`

  connexion.addEventListener("click", () => {
    utils.Deconnexion('proprio');
  });

  modal.classList.remove("d-none");


  function closeModal(e) {
    if (!modal.contains(e.target) && e.target.id != "Connexion") {
      modal.classList.add("d-none");
      document.removeEventListener("click", closeModal);
    }
  }

  setTimeout(() => {
    document.addEventListener("click", closeModal);
  }, 100); // Ajout d'un délai pour éviter la fermeture immédiate
}