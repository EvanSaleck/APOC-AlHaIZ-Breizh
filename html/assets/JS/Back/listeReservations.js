var ResasTout=[];

/* à utiliser pour les tris à rajouter dans les US 2.23 à 2.25
    var ResasEnCours=[];
    var ResasAVenir=[];
    var ResasPasse=[];

    var d = String(today.getDate()).padStart(2, '0');
    var m = String(today.getMonth() + 1).padStart(2, '0');
    var y = today.getFullYear();
    var today = new Date(d + '/' + m + '/' + y);
*/

/* à utiliser pour les tris à rajouter dans les US 2.23 à 2.25
    if(today.getTime() > res.date_depart.getTime()) {
        ResasPasse.push(res);
    }
    else if(today.getTime() < res.date_arrivee.getTime()) {
        ResasAVenir.push(res);
    }
    else if((today.getTime() >= res.date_arrivee.getTime())
        && (today.getTime() <= res.date_depart.getTime())) {
        ResasEnCours.push(res);
    }
    else { console.log("ERROR : Aucune date récupérée"); }
*/



document.addEventListener('DOMContentLoaded', init);

function init() {
    // Récupération des données de la BDD
    fetch('/api/getReservations').then(response => response.json()).then(data => {

        // Si aucune donnée n'est renvoyée par l'API, affiche qu'aucune réservation n'a été trouvée
        if(data.length == 0) {
            let contentReservations = document.getElementById('contentReservations');
            contentReservations.innerHTML = '<h1>Aucune réservation trouvée</h1>';
        }
        else {
            ResasTout = data;
            console.log(ResasTout);

            let bnTout = document.querySelector('#tout');

            // Maj du contenu du tableau avec des valeurs de la BDD
            bnTout.innerHTML = 'Tout (' + ResasTout.length + ')';
            

            let content = "";
            let max = (ResasTout.length < 7) ? ResasTout.length : 6 ;

            for (let i = 0; i<max; i++) {
                let res = ResasTout[i];
                console.log(res);

                content += `<tr>
    <td>${res.titre}</td>
    <td>${res.date_arrivee}</td>
    <td>${res.date_depart}</td>
    <td>${res.tarif_total}</td>
    <td>${res.pseudo}</td>
</tr>`;

                console.log(content);
            }

            let tbody = document.getElementById('tableContent');
            tbody.innerHTML = content;
        }
    }); 
}


// idCompteProprietaire pas encore utilisé pour récupérer les données liées au propriétaire connecté
function getReservationByOwnerId(idCompteProprietaire) {
    let reservations = [];
    fetch('/api/getReservations').then(response => response.json()).then(data => {
        foreach(data => {
            reservations.push(data);
        })
    });
    return reservations;
}


var bnTout = document.getElementById('tout');

// Change le style du bouton sélectionné
function handleButtonStyle(bnID) {
    // Boutons de tri pour les états de réservation
    let bnEnCours = document.getElementById('enCours');
    let bnAVenir = document.getElementById('aVenir');
    let bnPasse = document.getElementById('passe');
    let bnTout = document.getElementById('tout');
    

    bnEnCours.classList.remove("ongletSelect");
    bnAVenir.classList.remove("ongletSelect");
    bnPasse.classList.remove("ongletSelect");
    bnTout.classList.remove("ongletSelect");

    switch (bnID) {
        case 1:
            bnEnCours.classList.add("ongletSelect");
            break;

        case 2:
            bnAVenir.classList.add("ongletSelect");
            break;

        case 3:
            bnPasse.classList.add("ongletSelect");
            break;

        case 4:
            bnTout.classList.add("ongletSelect");
            break;

        default:
            console.log("ERROR : Invalid button ID given")
            break;
    }
}

// Recharge le contenu de la table dans la <div> "listeResa"
function reloadReservations(bnID) {
    handleButtonStyle(bnID);
    init();
}

/* Assigne la fonction de recharge du contenu de la table aux boutons
bnEnCours.addEventListener('click', reloadReservations(1));
bnAVenir.addEventListener('click', reloadReservations(2));
bnPasse.addEventListener('click', reloadReservations(3));
bnTout.addEventListener('click', reloadReservations(4));
*/