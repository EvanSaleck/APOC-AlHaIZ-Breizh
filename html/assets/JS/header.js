let currentUser = null;

addEventListener("DOMContentLoaded", () => {
  GetConnected();
  SetModalAndProfilePicture();
  AddListeners();
});

function AddListeners() {
  // Add listeners to the buttons
  let account = document.getElementById("account");
  // Setting Listeners for Account Icon
  account.addEventListener("click", () => {
    if (currentUser === null) {
      ShowModalConnexion();
    } else {
      ShowModalProfile();
    }
  });
}

function GetConnected() {
  if (sessionStorage.getItem("User") != null) {
    let user = JSON.parse(sessionStorage.getItem('User')) || "Guest";
    currentUser = user;
  }
}

function SetModalAndProfilePicture() { // Pass currentUser as an argument
    let account = document.getElementById("account");

    if (currentUser === null) {
      account.style.backgroundImage = "url('/html/assets/imgs/person-fill.svg')"; 
    } else if (currentUser && currentUser.url) { 
      account.style.backgroundImage = `url('${currentUser.url}')`;
    }
}

function ShowModalConnexion() {
  let modal = document.getElementById("ModalHovered");

  modal.style.display = "block";
  
}

