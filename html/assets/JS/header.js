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
    console.log("account icon clicked");
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
        let img = document.createElement("img");
        img.src = "/assets/imgs/person-fill.svg";
        img.width = 32;
        account.appendChild(img); 
    } else if (currentUser && currentUser.url) { 
        let img = document.createElement("img");
        img.src = currentUser.url; 
        img.width = 32;
        account.appendChild(img); 
    }
}

