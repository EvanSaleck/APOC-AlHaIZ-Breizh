document.addEventListener('DOMContentLoaded', init);

// Contient tous les résultats de réservations
var ResasTout=[];

var contentReservations = document.getElementById('contentReservations'); // Espace d'affichage du conetenu des réservations
var nbPasse = 0, nbEnCours = 0, nbAVenir = 0; // Valeurs pour stocker le nombre de réservations par filtre

// Boutons de tri pour les états de réservation
var bnEnCours = document.getElementById('enCours');
var bnAVenir = document.getElementById('aVenir');
var bnPasse = document.getElementById('passe');
var bnTout = document.getElementById('tout');
// Assigne la fonction de rechargement du contenu de la table aux boutons
bnEnCours.addEventListener('click', function(){reloadReservations(1)});
bnAVenir.addEventListener('click', function(){reloadReservations(2)});
bnPasse.addEventListener('click', function(){reloadReservations(3)});
bnTout.addEventListener('click', function(){reloadReservations(4)});

var enCours, aVenir, passe;


// Initialise la liste des réservations liées aux compte propriétaire connecté
function init() {
    // Récupère les informations du propriétaire
    let proprio = JSON.parse(sessionStorage.getItem("Proprio"));
    let idProprio = new FormData();
    idProprio.append("id", proprio["id_compte"]);

    document.getElementById('bonjour').innerHTML = "Bonjour " + proprio["prenom"] + ",";

    // Récupération des données de la BDD
    fetch('/api/getReservationsProprietaire', { method: "POST", body: idProprio })
        .then(response => response.json()).then(data => {

        // Si aucune donnée n'est renvoyée par l'API, affiche qu'aucune réservation n'a été trouvée
        let resVides = (data.length == 0);
        if(resVides) { 
            let displayAucuneReservations = document.getElementById("noReservations");
            displayAucuneReservations.classList.remove("d-none");
            
            utils.ThrowAlertPopup("Aucune réservation trouvée", "error");
        }
        else {
            ResasTout = data;
            console.log("Réservations trouvées pour " + proprio["prenom"] + " " + proprio["nom"] + " :\n");
            console.log(ResasTout)

            let today = new Date(); // La date actuelle

            let tbody = document.getElementById('tableContent'); // Corps du tableau pour afficher les objets de réservations
            tbody.innerHTML = "";

            // Maj du contenu du tableau avec des valeurs de la BDD
            for(let i = 0; i<ResasTout.length; i++) {
                let res = ResasTout[i];

                // Créé des objets dates pour savoir si une réservation est passée, en cours ou à venir
                let dateArr = new Date(res.date_arrivee);
                let dateDep = new Date(res.date_depart);
                
                let etatClass; // Classe à attribuer à la réservation pour l'affichage

                // Si la date d'aujourd'hui est supérieure à la date de départ,
                // considéré comme une réservation avec état "Passé"
                if(today > dateDep) {
                    etatClass = "passe";
                    nbPasse++;
                }
                // Si la date d'aujourd'hui est inférieure à la date d'arrivée,
                // considéré comme une réservation avec état "A venir"
                else if (today < dateArr) {
                    etatClass = "aVenir";
                    nbAVenir++;
                }
                // Sinon, considéré comme une réservation avec état "En cours"
                else {
                    etatClass = "enCours";
                    nbEnCours++;
                }

                // Formatage des dates au format JJ/MM/AAAA
                let valArr = res.date_arrivee.split('-');
                let valDep = res.date_depart.split('-');
                let dateArrFormatee = valArr[2] + "-" + valArr[1] + "-" + valArr[0];
                let dateDepFormatee = valDep[2] + "-" + valDep[1] + "-" + valDep[0];

                // Création de l'objet de réservation
                let tr = document.createElement('tr');

                let tdLogement = document.createElement('td');
                tdLogement.textContent = res.titre;
                let tdDateArr = document.createElement('td');
                tdDateArr.textContent = dateArrFormatee;
                let tdDateDep = document.createElement('td');
                tdDateDep.textContent = dateDepFormatee;
                let tdTarif = document.createElement('td');
                tdTarif.textContent = res.tarif_total.replace(".", ",") + '€';
                let tdClient = document.createElement('td');
                tdClient.textContent = res.pseudo;

                tr.appendChild(tdLogement);
                tr.appendChild(tdDateArr);
                tr.appendChild(tdDateDep);
                tr.appendChild(tdTarif);
                tr.appendChild(tdClient);

                tr.setAttribute('class', etatClass);

                tbody.appendChild(tr);
            }

            // Ajour de lien href vers la page de détail de la réservation associée
            let reservations = document.querySelectorAll('tbody > tr');
            let i = 0;
            reservations.forEach(resa => { resa.addEventListener('click', function(e){
                    sessionStorage.setItem('idresa', ResasTout[i].id_reservation);
                    console.log(ResasTout[i].id_reservation);
                    window.location.href = `/back/reservations/details`;
                    i++;
                });
            });
            
            // Indicateur du nombre de réservations en cours
            let nbReservationsEnCours = document.getElementById('nbReservationsEnCours');
            nbReservationsEnCours.innerHTML = "Vous avez " + nbEnCours + " réservations en cours";
        }

        enCours = document.getElementsByClassName("enCours");
        aVenir = document.getElementsByClassName("aVenir");
        passe = document.getElementsByClassName("passe");

        // Affiche le nombre de réservations par filtre
        bnEnCours.innerHTML = 'En cours (' + (resVides ? '0' : nbEnCours) + ')';
        bnAVenir.innerHTML = 'A venir (' + (resVides ? '0' : nbAVenir) + ')';
        bnPasse.innerHTML = 'Passé (' + (resVides ? '0' : nbPasse) + ')';
        bnTout.innerHTML = 'Tout (' + ResasTout.length + ')';

        // Utilise le choix de tri le plus pertinent en fonction des réservations
        if(nbEnCours > 0) { bnEnCours.click(); }
        else if(nbAVenir > 0) { bnAVenir.click(); }
    }); 
}


// Change le style du bouton sélectionné
function handleButtonStyle(bnID) {
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
            console.log("ERREUR : ID de bouton invalide");
            break;
    }
}


// Recharge le contenu de la table dans la <div> "listeResa" en fonction du filtre choisi
function reloadReservations(bnID) {
    handleButtonStyle(bnID);

    let displayAucuneReservations = document.getElementById("noReservations");

    // Affiche / cache les réservations associées au filtre choisi
    switch (bnID) {
        case 1:
            for(var i = 0; i < enCours.length; i++){ enCours[i].classList.remove("d-none"); }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].classList.add("d-none"); }
            for(var i = 0; i < passe.length; i++){ passe[i].classList.add("d-none"); }
            if(nbEnCours == 0) { displayAucuneReservations.classList.remove("d-none");}
            else { displayAucuneReservations.classList.add("d-none");}
            break;

        case 2:
            for(var i = 0; i < enCours.length; i++){ enCours[i].classList.add("d-none"); }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].classList.remove("d-none"); }
            for(var i = 0; i < passe.length; i++){ passe[i].classList.add("d-none"); }
            if(nbAVenir == 0) { displayAucuneReservations.classList.remove("d-none");}
            else { displayAucuneReservations.classList.add("d-none");}
            break;

        case 3:
            for(var i = 0; i < enCours.length; i++){ enCours[i].classList.add("d-none"); }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].classList.add("d-none"); }
            for(var i = 0; i < passe.length; i++){ passe[i].classList.remove("d-none"); }
            if(nbPasse == 0) { displayAucuneReservations.classList.remove("d-none");}
            else { displayAucuneReservations.classList.add("d-none");}
            break;

        case 4:
            for(var i = 0; i < enCours.length; i++){ enCours[i].classList.remove("d-none"); }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].classList.remove("d-none"); }
            for(var i = 0; i < passe.length; i++){ passe[i].classList.remove("d-none"); }
            if(ResasTout.length == 0) { displayAucuneReservations.classList.remove("d-none");}
            else { displayAucuneReservations.classList.add("d-none");}
            break;

        default:
            console.log("ERREUR : ID de bouton invalide");
            break;
    }
}
