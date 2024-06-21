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

var affichageAucuneRéservations = `<div id="listeReservations">
<table>
    <thead>
        <tr>
            <th>Logement</th>
            <th>Date d'arrivée</th>
            <th>Date de départ</th>
            <th>Tarif global</th>
            <th>Client</th>
        </tr>
    </thead>

    <tbody id="tableContent">
    </tbody>
</table>
<h1 id="noReservations">Aucune réservation trouvée</h1>
</div>`


// Initialise la liste des réservations liées aux compte propriétaire connecté
function init() {
    // Récupère les informations du propriétaire
    fetch('/api/getOwnerById').then(resp => resp.json()).then(data => {
        document.getElementById('bonjour').innerHTML = "Bonjour " + data[0].prenom + ",";
    });

    // Récupération des données de la BDD
    fetch('/api/getReservations').then(response => response.json()).then(data => {

        // Si aucune donnée n'est renvoyée par l'API, affiche qu'aucune réservation n'a été trouvée
        let resVides = (data.length == 0);
        if(resVides) { contentReservations.innerHTML = affichageAucuneRéservations; }
        else {
            ResasTout = data;
            console.log("Réservations trouvées :\n" + ResasTout);
            
            let max = (ResasTout.length < 7) ? ResasTout.length : 6; // Nombre maximum de réservations affichées sur la page par défaut

            let today = new Date(); // La date actuelle


            let tbody = document.getElementById('tableContent'); // Corps de la table pour insérer les objets de réservation
            tbody.innerHTML = "";

            // Maj du contenu du tableau avec des valeurs de la BDD
            for(let i = 0; i<max; i++) {
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


                // Reformate les dates pour les afficher en format Français
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
                tdTarif.textContent = res.tarif_total + '€';
                let tdClient = document.createElement('td');
                tdClient.textContent = res.pseudo;

                tr.appendChild(tdLogement);
                tr.appendChild(tdDateArr);
                tr.appendChild(tdDateDep);
                tr.appendChild(tdTarif);
                tr.appendChild(tdClient);

                tr.class = etatClass;

                tbody.appendChild(tr);
            }

            // Attribution d'un href pour rediriger vers la page de détail qui affiche la réservation associée
            let reservations = document.querySelectorAll('tbody > tr');
            let i = 0;
            reservations.forEach(resa => { resa.addEventListener('click', function(e){
                    sessionStorage.setItem('idResa', ResasTout[i].id_reservation);
                    console.log(ResasTout[i].id_reservation);
                    window.location.href = `reservations/details`;
                    i++;
                });
            });
            
            // Indicateur du nombre de réservations en cours
            let nbReservationsEnCours = document.getElementById('nbReservationsEnCours');
            nbReservationsEnCours.innerHTML = "vous avez " + nbEnCours + " réservations en cours";
        }

        // Affiche le nombre de réservations par filtre
        bnEnCours.innerHTML = 'En cours (' + (resVides ? '0' : nbEnCours) + ')';
        bnAVenir.innerHTML = 'A venir (' + (resVides ? '0' : nbAVenir) + ')';
        bnPasse.innerHTML = 'Passé (' + (resVides ? '0' : nbPasse) + ')';
        bnTout.innerHTML = 'Tout (' + ResasTout.length + ')';
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

    let enCours = document.getElementsByClassName("enCours");
    let aVenir = document.getElementsByClassName("aVenir");
    let passe = document.getElementsByClassName("passe");

    // Affiche / cache les réservations associées au filtre choisi
    switch (bnID) {
        case 1:
            for(var i = 0; i < enCours.length; i++){ enCours[i].removeAttribute("style"); }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].style.display = "none"; }
            for(var i = 0; i < passe.length; i++){ passe[i].style.display = "none"; }
            if(nbEnCours == 0) { contentReservations.innerHTML = affichageAucuneRéservations; }
            break;

        case 2:
            for(var i = 0; i < enCours.length; i++){ enCours[i].style.display = "none"; }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].removeAttribute("style"); }
            for(var i = 0; i < passe.length; i++){ passe[i].style.display = "none"; }
            if(nbAVenir == 0) { contentReservations.innerHTML = affichageAucuneRéservations; }
            break;

        case 3:
            for(var i = 0; i < enCours.length; i++){ enCours[i].style.display = "none"; }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].style.display = "none"; }
            for(var i = 0; i < passe.length; i++){ passe[i].removeAttribute("style"); }
            if(nbPasse == 0) { contentReservations.innerHTML = affichageAucuneRéservations; }
            break;

        case 4:
            for(var i = 0; i < enCours.length; i++){ enCours[i].removeAttribute("style"); }
            for(var i = 0; i < aVenir.length; i++){ aVenir[i].removeAttribute("style"); }
            for(var i = 0; i < passe.length; i++){ passe[i].removeAttribute("style"); }
            if(ResasTout.length == 0) { contentReservations.innerHTML = affichageAucuneRéservations; }
            break;

        default:
            console.log("ERREUR : ID de bouton invalide");
            break;
    }
}
