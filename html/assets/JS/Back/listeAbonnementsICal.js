import { ThrowAlertPopup } from "../utils.js";

document.addEventListener('DOMContentLoaded', function() {
    // si une pop up est stockée en local storage, on l'affiche
    const storedPopup = localStorage.getItem('alertPopup');
    if (storedPopup) {
        const { message, type } = JSON.parse(storedPopup);
        ThrowAlertPopup(message, type);
        localStorage.removeItem('alertPopup');
    }
    
    // Récupération des abonnements iCal
    fetch('/api/getAbonnementsICalByProprietaire/', {
        method: 'GET',  
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
    .then(data => {
        // si le tableau est vide, on ajoute une ligne pour le signaler
        if(data.length == 0) {
            let tbody = document.getElementById('tbodyListeLogements');
            let tr = document.createElement('tr');
            let td = document.createElement('td');
            td.innerHTML = "Aucun abonnement iCal";
            td.setAttribute('colspan', '9');
            td.setAttribute('style', 'text-align: center;');
            tr.appendChild(td);
            tbody.appendChild(tr);
        } else {
            // on remplit le tableau 
            let tbody = document.getElementById('tbodyListeLogements');
            data.forEach(element => {
                let tr = document.createElement('tr');
                console.log(element);
                let titre = document.createElement('td');
                titre.innerHTML = element.titre_abo;
                tr.appendChild(titre);

                let dateDeb = document.createElement('td');
                dateDeb.innerHTML = element.date_debut;
                tr.appendChild(dateDeb);

                let dateFin = document.createElement('td');
                dateFin.innerHTML = element.date_fin;
                tr.appendChild(dateFin);

                let logements = document.createElement('td');
                let logementsString = "";
                element.logements.forEach(logement => {
                    logementsString += logement.titre + ", ";
                });

                logementsString = logementsString.slice(0, -2);

                logements.innerHTML = logementsString;
                tr.appendChild(logements);
               
                
                // on ajoute un bouton permettant de copier l'adresse
                let td = document.createElement('td');
                let copyBtn = document.createElement('button');
                // button.innerHTML = "Copier l'url";
                copyBtn.id = 'copyIconButton';
                copyBtn.innerHTML = "<img src='/assets/imgs/basicIcons/copy.svg' alt='Copier l'url'>";

                // on ajoute un écouteur d'événement pour copier l'url
                copyBtn.addEventListener('click', function() {
                    let text = element.url;
                    navigator.clipboard.writeText(text).then(function() {
                        ThrowAlertPopup('URL copiée !', 'success')
                    }, function(err) {
                        console.error('Erreur lors de la copie de l\'url : ', 'error');
                    });
                });
                td.appendChild(copyBtn);
                tr.appendChild(td);

                // on ajoute un bouton permettant de modifier l'abonnement
                let update = document.createElement('td');
                let updateBtn = document.createElement('button');
                updateBtn.id = 'penIconButton';
                updateBtn.innerHTML = "<img src='/assets/imgs/basicIcons/penUpdate.svg' alt='Modifier'>";
                updateBtn.addEventListener('click', function() {
                    window.location.href = `/reservations/abonnements/iCal/edit/${element.id}`;
                });
                update.appendChild(updateBtn);
                tr.appendChild(update);

                // on ajoute un bouton permettant de supprimer l'abonnement
                let del = document.createElement('td');
                let delBtn = document.createElement('button');
                delBtn.id = 'trashIconButton';
                delBtn.innerHTML = "<img src='/assets/imgs/basicIcons/trashDelete.svg' alt='Supprimer'>";
                delBtn.addEventListener('click', function() {
                    fetch(`/api/reservations/abonnements/iCal/delete/${element.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if(data === true) {
                            // on supprime la ligne
                            tr.remove();
                            let message  = "Abonnement supprimé";
                            ThrowAlertPopup(message, 'success');
                            // si le tableau est vide, on ajoute une ligne pour le signaler
                            if(tbody.children.length == 0) {
                                let tr = document.createElement('tr');
                                let td = document.createElement('td');
                                td.innerHTML = "Aucun abonnement iCal";
                                td.setAttribute('colspan', '6');
                                td.setAttribute('style', 'text-align: center;');
                                tr.appendChild(td);
                                tbody.appendChild(tr);
                            }
                        } else {
                            ThrowAlertPopup('Erreur lors de la suppression de l\'abonnement, veuillez réessayer plus tard. <br> Si le problème persiste, merci de contacter un administrateur', 'error');
                        }
                    });
                });
                del.appendChild(delBtn);
                tr.appendChild(del);
                
                tbody.appendChild(tr);
            });        
        }           
    }).catch((error) => {
        console.error('Error:', error);
    });
});