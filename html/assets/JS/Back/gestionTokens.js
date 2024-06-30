import * as utils from "../utils.js";

let zonetoken = document.getElementById("zonetoken");
let tabtoken;

let btnGenerer = document.getElementById("generateToken");
btnGenerer.addEventListener("click", () => GenerateToken());

// Récupération des tokens
fetch("/api/getAllTokenById")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
    tabtoken = data;
    zonetoken.innerHTML = ""; 
    data.forEach((token, i) => {
      // on ajoute un token à la liste
      zonetoken.innerHTML += `
      <div class="token-container">
          <div class="mask" data-id="${i}" id="token-${i}"><p>${token.cle}</p></div>
          <div class="btn" data-id="${token.cle}">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
              </svg>
          </div>
      </div>`;
    });
  });

// on floute les tokens sauf quand on passe la souris dessus 
zonetoken.addEventListener("mouseover", (e) => {
  if (e.target.closest(".mask")) {
    e.target.closest(".mask").classList.remove("mask");
  }
});

zonetoken.addEventListener("mouseout", (e) => {
  if (e.target.closest(".token-container") && !e.target.closest(".mask")) {
    e.target.closest(".token-container").querySelector('div[data-id]').classList.add("mask");
  }
});

zonetoken.addEventListener("click", (e) => {
  if (e.target.closest(".btn")) {
    let tokenID = e.target.closest(".btn").dataset.id;
    deleteToken(tokenID);
  }
});

// Suppression d'un token
function deleteToken(id) {
  let formData = new FormData();
  formData.append("id_cle", id);
  formData.append("id_proprio", JSON.parse(sessionStorage.getItem("Proprio")).id_compte);

  fetch("/api/deleteToken/", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(response => {
    if (response == "Token supprime") {
      utils.ThrowAlertPopup("Token supprimé", "success");
      setTimeout(() => {
        location.reload(); 
      }, 1500);
    } else {
      utils.ThrowAlertPopup("Erreur lors de la suppression du token", "error");
    }
  })
  .catch(error => {
    utils.ThrowAlertPopup(error, "error");
  });
}

// Génération d'un token
function GenerateToken(){
    let form = new FormData();
    let email = JSON.parse(sessionStorage.getItem("Proprio")).e_mail;    

    form.append("id_proprio", JSON.parse(sessionStorage.getItem("Proprio")).id_compte);
    fetch("/api/generateToken", {
        method: "POST",
        body: form,
    })
    .then(response => response.json())
    .then(data => {
        if(data === "Token genere"){
            utils.ThrowAlertPopup("Token généré", "success");
            setTimeout(() => {
                location.reload(); 
            }, 1500);
        } else {
            utils.ThrowAlertPopup("Erreur lors de la génération du token", "error");
        }
    })
    .catch(error => {
        utils.ThrowAlertPopup(error, "error");
    });
}
