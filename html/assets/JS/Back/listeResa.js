// import des fonctions JS
// import { displayNoteEtoiles } from './fonctions.js';
import { getHouseTitleByReservationId } from '../../Models/Reservation'
import { getClientUsernameByReservationId } from '../../Models/Reservation'

var bnEnCours = document.getElementById('enCours');
var bnAVenir = document.getElementById('aVenir');
var bnPasse = document.getElementById('passe');
var bnTout = document.getElementById('tout');

var tbody = document.getElementById('tableContent');

var ResasTout=[];
var ResasEnCours=[];
var ResasAVenir=[];
var ResasPasse=[];


function init() {

    var d = String(today.getDate()).padStart(2, '0');
    var m = String(today.getMonth() + 1).padStart(2, '0');
    var y = today.getFullYear();
    var today = new Date(d + '/' + m + '/' + y);


    var listeResas = getReservationByOwnerId();
    listeResasParsed = JSON.parse(listeResas);

    fetch('/api/getAllReservation')
        .then(response => response.json())
        .then(data => {
                
            if(data.length == 0) {
                var listeResa = document.getElementById('listeResa');
                listeResa.innerHTML = '<h1 class="error">Aucunes réservations trouvées</h1>';
            }
            else {
                tbody.innerHTML("");

                data.forEach(res => {
                    ResasTout.push(res);
                    
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
                    else { console.log("ERROR : Date not caught"); }
                });

                for (i=0; i<6; i++) {
                    let res = ResasEnCours[i];

                    tbody.append(`<tr>
                        <td>${getHouseTitleByReservationId(res.R_id_logement)}</td>
                        <td>${res.date_arrivee}</td>
                        <td>${res.date_depart}</td>
                        <td>${res.tarif_total}</td>
                        <td>${getClientUsernameByReservationId(res.R_id_compte)}</td>
                    </tr>`);
                }
                        
                        if (logement.nom_ville && logement.titre && logement.prix_nuit_ttc && logement.description) {
                            divCard.querySelector('.nomVille').textContent = logement.nom_ville.toUpperCase();
                            divCard.querySelector('.titre').textContent = logement.titre;
                            divCard.querySelector('.tarif').textContent = logement.prix_nuit_ttc + '€/nuit';
                            divCard.querySelector('.description').textContent = logement.description;
                            divCard.querySelector('.nbAvis').textContent = logement.nb_avis + ' avis';
                            displayNoteEtoiles(divCard.querySelector('.note'), logement.moyenne_logement);
                            let pathImage = logement.image_principale + '.svg';
                            
                            fileExists(pathImage).then(exists => {
                                if (exists) {
                                    divCard.querySelector('.imagePrincipale').src = pathImage;
                                } else {
                                    divCard.querySelector('.imagePrincipale').src = '/assets/imgs/error.png';
                                }
                            });

                            divCard.addEventListener('click', function() {
                                window.location.href = `/logement/${logement.id_logement}`;
                            });
                        } else {
                            divCard.querySelector('.description').textContent = "Erreur lors du chargement des données du logement";
                            divCard.querySelector('.imagePrincipale').src = '/assets/imgs/error.png';
                        }
                        
                        cardsContainer.appendChild(divCard);
            }
        }); 
}



function handleButtonStyle(bnId) {
    /*if (bnEnCours.classList.contains("ongletSelect")){
        bnEnCours.classList.remove("ongletSelect");
    }
    else if (bnAVenir.classList.contains("ongletSelect")){
        bnAVenir.classList.remove("ongletSelect");
    }
    else if (bnPasse.classList.contains("ongletSelect")){
        bnPasse.classList.remove("ongletSelect");
    }
    else if (bnTout.classList.contains("ongletSelect")){
        bnTout.classList.remove("ongletSelect");
    }*/

    bnEnCours.classList.remove("ongletSelect");
    bnAVenir.classList.remove("ongletSelect");
    bnPasse.classList.remove("ongletSelect");
    bnTout.classList.remove("ongletSelect");
    bnId.classList.add("ongletSelect");
}

// Recharge le contenu de la table dans la <div> "listeResa"
function reloadReservations(bnId) {
    handleButtonStyle(bnId);
}


// Assigne la fonction de recharge du contenu de la table aux boutons
bnEnCours.addEventListener('click', reloadReservations(bnEnCours.id));
bnAVenir.addEventListener('click', reloadReservations(bnAVenir.id));
bnPasse.addEventListener('click', reloadReservations(bnPasse.id));
bnTout.addEventListener('click', reloadReservations(bnTout.id));



// au chargement du dom
document.addEventListener('DOMContentLoaded', function() {
    adjustMarginTop();
    window.addEventListener('resize', adjustMarginTop);

    var cardTemplate = document.getElementsByClassName('card')[0];
    var cardsContainer = document.getElementById('cardsContainer');


    if ("content" in document.createElement("template")) {
        // on récupère les logements
        fetch('/api/getLogementsDataForCards')
            .then(response => response.json())
            .then(data => {
                // Test tableau vide
                // data = [];
                
                if(data.length == 0){
                    cardsContainer.innerHTML = '<h2 class="error">Aucun logement trouvé ಥ_ಥ</h2>';
                }else{
                    data.sort(() => Math.random() - 0.5);
                    data.forEach(logement => {
                        let cardContent = cardTemplate.content;
                        
                        let divCard = document.createElement('div');
                        divCard.classList.add('card');
                        
                        divCard.setAttribute('id', logement.id_logement);
                        
                        divCard.appendChild(cardContent.cloneNode(true));
                        
                        if (logement.nom_ville && logement.titre && logement.prix_nuit_ttc && logement.description) {
                            divCard.querySelector('.nomVille').textContent = logement.nom_ville.toUpperCase();
                            divCard.querySelector('.titre').textContent = logement.titre;
                            divCard.querySelector('.tarif').textContent = logement.prix_nuit_ttc + '€/nuit';
                            divCard.querySelector('.description').textContent = logement.description;
                            divCard.querySelector('.nbAvis').textContent = logement.nb_avis + ' avis';
                            displayNoteEtoiles(divCard.querySelector('.note'), logement.moyenne_logement);
                            let pathImage = logement.image_principale + '.svg';
                            
                            fileExists(pathImage).then(exists => {
                                if (exists) {
                                    divCard.querySelector('.imagePrincipale').src = pathImage;
                                } else {
                                    divCard.querySelector('.imagePrincipale').src = '/assets/imgs/error.png';
                                }
                            });

                            divCard.addEventListener('click', function() {
                                window.location.href = `/logement/${logement.id_logement}`;
                            });
                        } else {
                            divCard.querySelector('.description').textContent = "Erreur lors du chargement des données du logement";
                            divCard.querySelector('.imagePrincipale').src = '/assets/imgs/error.png';
                        }
                        
                        cardsContainer.appendChild(divCard);
                    });  
                }
                
                
            });
    }
});

function adjustMarginTop() {
    var marginTopValue = (header.offsetHeight + 20) + 'px'; 
    cardsContainer.style.marginTop = marginTopValue; 
}
