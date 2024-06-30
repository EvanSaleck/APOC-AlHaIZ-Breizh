import * as utils from "../utils.js";

let currentUser = null;

addEventListener("DOMContentLoaded", () => {
  GetConnected();
  SetModalAndProfilePicture();
  AddListeners();
});

// Fonction pour ajouter les listeners sur les boutons de connexion et de profil
function AddListeners() {
  // Si la taille de l'écran est inférieure à 992px, on ajoute un listener sur le bouton de connexion
  let compte;
  if (window.innerWidth < 768) {
    compte = document.getElementById("navcpt");
  } else {  
    compte = document.getElementById("Compte")
  }
  compte.addEventListener("click", () => {
    if (currentUser === null) {
      ShowModalConnexion();
    } else {
      ShowModalProfile();
    }
  });

  let modale = document.getElementById("Bubble");

}

// Fonction pour récupérer l'utilisateur connecté
function GetConnected() {
  if (sessionStorage.getItem("User") != null) {
    let user = JSON.parse(sessionStorage.getItem('User')) || "Guest";
    console.log(user);
    currentUser = user;
  }
}

// Fonction pour définir l'image de profil et le modal de connexion
function SetModalAndProfilePicture() { 
    let compte = document.getElementById("Compte");
    if (currentUser === undefined || currentUser === null) {
      compte.style.backgroundImage = "url('/assets/imgs/person-fill.svg')"; 
    } else if (currentUser && currentUser.photo_profil) { 
      compte.style.backgroundImage = "url('" + currentUser.photo_profil + "')";
    }
}

// Fonction pour afficher le modal de connexion
function ShowModalConnexion() {

  let modal = document.getElementById("Bulle");
  let profile = document.getElementById("Profil");
  profile.innerHTML = `<p>S'inscrire</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>`;
  profile.addEventListener("click", () => {
    utils.CreateInscriptionModal();
  });
  let connexion = document.getElementById("btnConnexion");
  connexion.innerHTML = `<p>Se Connecter</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>`;
  
  connexion.addEventListener("click", () => {
    utils.CreateConnexionModal();
  });

  modal.classList.remove("d-none");

  setTimeout(() => {
    document.addEventListener("click", closeModal);
  }, 1000); 
}

// Fonction pour afficher le modal de profil
function ShowModalProfile() {
  let modal = document.getElementById("Bulle");
  let profile = document.getElementById("Profil");
  profile.innerHTML = `<p>Mon Compte</p><svg width="35" height="35" viewBox="0 0 45 44" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M22.5 24.75C29.332 24.75 34.875 19.207 34.875 12.375C34.875 5.54297 29.332 0 22.5 0C15.668 0 10.125 5.54297 10.125 12.375C10.125 19.207 15.668 24.75 22.5 24.75ZM33.5 27.5H28.7648C26.857 28.3766 24.7344 28.875 22.5 28.875C20.2656 28.875 18.1516 28.3766 16.2352 27.5H11.5C5.42422 27.5 0.5 32.4242 0.5 38.5V39.875C0.5 42.1523 2.34766 44 4.625 44H40.375C42.6523 44 44.5 42.1523 44.5 39.875V38.5C44.5 32.4242 39.5758 27.5 33.5 27.5Z" fill="black"/>
  </svg>`

  profile.addEventListener('click', function() {
    location.href = "/compte";
  });
  let connexion = document.getElementById("btnConnexion");

  connexion.innerHTML = `<p>Se Déconnecter</p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>`

  connexion.addEventListener("click", () => {
    utils.Deconnexion('user');
  });

  modal.classList.remove("d-none");

  setTimeout(() => {
    document.addEventListener("click", closeModal);
  }, 1000); // Ajou
}

// Fonction pour fermer le modal
function closeModal(e) {
  let modal = document.getElementById("Bulle");
  if (!modal.contains(e.target) && e.target.id != "Connexion") {
    console.log("close")
    modal.classList.toggle("d-none");
    document.removeEventListener("click", closeModal);
  }
}