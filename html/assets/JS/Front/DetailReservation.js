let id = new FormData();
id.append('id', 1);
fetch('/api/getReservationById', { method: 'POST', body: id })
.then(response => response.json())
.then(data => {
    // console.log(data);
    document.getElementById('dateArrivee').textContent = data.date_arrivee;
    document.getElementById('dateFin').textContent = data.date_depart;
    document.getElementById('sctNbOccupants').textContent = `${data.nb_occupant} occupants`;
    document.getElementById('tarifttc').textContent = `${data.total_tarif_ttc}€`;
    document.getElementById('taxeSejour').textContent = `${data.taxe_sejour}€`;
    document.getElementById('totalTtc').textContent = `${data.tarif_total}€`;
});

if(sessionStorage.getItem('Data')!=null){
    let data = JSON.parse(sessionStorage.getItem('Data'));
    document.getElementById('titrelogement').value = data.nom;
    document.getElementById('adresselogement').value = data.adresse;
    document.getElementById('villelogement').value = data.ville;
    let img = document.getElementById('imglogement');
}
// const section = document.querySelector("section"),
// overlay = document.querySelector(".overlay"),
// procederPaiement = document.querySelector(".proceder_paiement"),
// modalBox = document.querySelector(".modal-box");

// procederPaiement.addEventListener("click", () => {
//     section.classList.add("active");

//     // Faire disparaitre le bouton au bout de 3 secondes
//     setTimeout(() => {
//         section.classList.remove("active");
//     }, 3000);
// });

// // Cacher la modale avec clic sur la modale
// modalBox.addEventListener("click", () => {
//     section.classList.remove("active"); 
// });

// // Cacher la modale avec clic sur le reste de la page
// overlay.addEventListener("click", () => {
//     section.classList.remove("active"); 
// });

// var logementData = JSON.parse(sessionStorage.getItem('logement'));

// console.log(logementData);

// // Fonction pour mettre à jour les éléments HTML avec les données de réservation
// function updateReservationInfo() {
//     // Sélectionner le conteneur principal
//     let conteneur = document.querySelector('.infosReservationDev');

//     console.log(conteneur)

//     let tt = conteneur.querySelectorAll('.info-row');
//     console.log(tt)

//     // Accéder aux éléments spécifiques dans le conteneur
//     let dateArriveeElement = tt[0].querySelector('#date_arrivee');
//     let dateDepartElement = tt[1].querySelector('.date_depart');
//     let nbOccupantElement = tt[2].querySelector('.nb_occupant');
//     let prixNuitTtcElement = tt[3].querySelector('.prix_nuit_ttc');
//     let taxeSejourElement = tt[4].querySelector('.taxe_sejour');
//     let totalTarifTtcElement = tt[5].querySelector('.total_tarif_ttc');

//     // Mettre à jour les éléments avec les données de réservation
//     dateArriveeElement.textContent = logementData.date_arrivee;
//     dateDepartElement.textContent = logementData.date_depart;
//     nbOccupantElement.textContent = `${logementData.nb_occupant} occupants`;
//     prixNuitTtcElement.textContent = `${logementData.prix_nuit_ttc}€`;
//     taxeSejourElement.textContent = `${logementData.taxe_sejour}€`;
//     totalTarifTtcElement.textContent = `${(parseFloat(logementData.prix_nuit_ttc) * 12 + parseFloat(logementData.taxe_sejour)).toFixed(2)}€`; // Calcul du total pour 12 nuits
// }

// updateReservationInfo();