let currentUser = null;

addEventListener("DOMContentLoaded", () => {
  GetConnected();
  SetModalAndProfilePicture();
  AddListeners();
});

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

function GetConnected() {
  if (sessionStorage.getItem("Proprio") != null) {
    let user = JSON.parse(sessionStorage.getItem('Proprio'));
    console.log(user);
    currentUser = user;
  }
}

function SetModalAndProfilePicture() { 
    let compte = document.getElementById("Compte");
    if (currentUser === undefined || currentUser === null) {
      compte.style.backgroundImage = "url('/assets/imgs/person-fill.svg')"; 
    } else if (currentUser && currentUser.photo_profil) { 
      compte.style.backgroundImage = "url('" + currentUser.photo_profil + "')";
    }
}

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

  connexion.innerHTML = `<p>Se Déconnecter</p><svg width="35" height="35" viewBox="0 0 56 45" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M13.5951 34.2655C16.173 38.445 20.053 41.6725 24.6448 43.457C29.2365 45.2415 34.2887 45.4853 39.0326 44.1512C43.7764 42.8172 47.9523 39.9784 50.9249 36.0667C53.8974 32.1551 55.5038 27.3847 55.4998 22.4814C55.4957 17.5782 53.8813 12.8105 50.9023 8.90367C47.9233 4.99689 43.7427 2.16494 38.9967 0.83869C34.2506 -0.487557 29.1988 -0.235492 24.61 1.55654C20.0212 3.34856 16.1466 6.58245 13.5757 10.7661L17.3626 13.0683C19.4292 9.70537 22.5436 7.10596 26.2321 5.66552C29.9206 4.22507 33.9812 4.02246 37.7962 5.08851C41.6111 6.15455 44.9715 8.4309 47.366 11.5712C49.7606 14.7115 51.0582 18.5438 51.0615 22.4851C51.0647 26.4264 49.7735 30.2608 47.3841 33.405C44.9948 36.5492 41.6382 38.8311 37.825 39.9034C34.0119 40.9757 29.9509 40.7798 26.26 39.3454C22.5692 37.911 19.4504 35.3167 17.3783 31.9572L13.5951 34.2655Z" fill="black"/>
  <path d="M40.2803 23.3571C41.1087 23.3571 41.7803 22.6855 41.7803 21.8571C41.7803 21.0287 41.1087 20.3571 40.2803 20.3571V23.3571ZM0.439125 20.7965C-0.14666 21.3822 -0.14666 22.332 0.439125 22.9178L9.98507 32.4637C10.5709 33.0495 11.5206 33.0495 12.1064 32.4637C12.6922 31.8779 12.6922 30.9282 12.1064 30.3424L3.62111 21.8571L12.1064 13.3718C12.6922 12.786 12.6922 11.8363 12.1064 11.2505C11.5206 10.6647 10.5709 10.6647 9.98507 11.2505L0.439125 20.7965ZM40.2803 20.3571L1.49979 20.3571V23.3571L40.2803 23.3571V20.3571Z" fill="black"/>
  </svg>`

  connexion.addEventListener("click", () => {
    utils.Deconnexion();
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