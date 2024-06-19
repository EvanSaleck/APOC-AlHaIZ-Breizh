import { ThrowAlertPopup } from "../utils.js";

document.addEventListener('DOMContentLoaded', function() {
    const storedPopup = localStorage.getItem('alertPopup');
    if (storedPopup) {
        const { message, type } = JSON.parse(storedPopup);
        ThrowAlertPopup(message, type);
    }
    
    fetch('/api/getAllAbonnementsICal/', {
        method: 'GET',  
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
    .then(data => {
        console.log(data);
        if(data.length == 0) {
            let tbody = document.getElementById('tbodyListeLogements');
            let tr = document.createElement('tr');
            let td = document.createElement('td');
            td.innerHTML = "Aucun abonnement iCal";
            td.setAttribute('colspan', '4');
            td.setAttribute('style', 'text-align: center;');
            tr.appendChild(td);
            tbody.appendChild(tr);
        } else {
            let tbody = document.getElementById('tbodyListeLogements');
            data.forEach(element => {
                let tr = document.createElement('tr');

                let dateDeb = document.createElement('td');
                dateDeb.innerHTML = element.date_debut;
                tr.appendChild(dateDeb);

                let dateFin = document.createElement('td');
                dateFin.innerHTML = element.date_fin;
                tr.appendChild(dateFin);

                // le element.logements est un tableau de logements, on l'affichce sous forme de chaine de caractères
                let logements = document.createElement('td');
                let logementsString = "";
                element.logements.forEach(logement => {
                    logementsString += logement.titre + ", ";
                });

                // on enlève la dernière virgule
                logementsString = logementsString.slice(0, -2);

                logements.innerHTML = logementsString;
                tr.appendChild(logements);
               
                
                // on ajoute un bouton permettant de copier l'adresse
                let td = document.createElement('td');
                let button = document.createElement('button');
                button.innerHTML = "Copier l'url";

                button.addEventListener('click', function() {
                    let text = element.url;
                    navigator.clipboard.writeText(text).then(function() {
                        ThrowAlertPopup('URL copiée !', 'success')
                    }, function(err) {
                        console.error('Erreur lors de la copie de l\'url : ', 'error');
                    });
                });
                td.appendChild(button);
                tr.appendChild(td);

                // on ajoute un bouton de modification avec comme icone le assets/imgs/basicIcons/penUpdate.svg
                let update = document.createElement('td');
                let updateBtn = document.createElement('button');
                updateBtn.innerHTML = "<img src='/assets/imgs/basicIcons/penUpdate.svg' alt='Modifier'>";
                updateBtn.addEventListener('click', function() {
                    window.location.href = `/reservations/abonnements/iCal/edit/${element.id}`;
                });
                update.appendChild(updateBtn);


                tbody.appendChild(tr);
            });        
        }           
    }).catch((error) => {
        console.error('Error:', error);
    });
});