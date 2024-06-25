import * as utils from "../utils.js";

let btnConnexion = document.getElementById("btnConnexion");
btnConnexion.addEventListener("click", () => {
    utils.Connexion('proprio');
});