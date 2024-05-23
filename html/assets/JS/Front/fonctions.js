
var starFull = '<img class="noteEtoile" src="/assets/imgs/notes/star_full.svg" alt="">';
var starEmpty = '<img class="noteEtoile" src="/assets/imgs/notes/star_empty.svg" alt="">';
var starHalf = '<img class="noteEtoile" src="/assets/imgs/notes/star_half.svg" alt="">';

function displayNoteEtoiles(div,note) {
    div.innerHTML = '';
    for (let i = 0; i < 5; i++) {
        if (note >= 1) {
            div.innerHTML += starFull;
            note--;
        } else if (note >= 0.5) {
            div.innerHTML += starHalf;
            note = 0;
        } else {
            div.innerHTML += starEmpty;
        }
    }
}

async function fileExists(path) {
    try {
        const response = await fetch(path, { method: 'HEAD' });
        return response.ok;
    } catch (error) {
        console.error('Erreur:', error);
        return false;
    }
}

function Connexion(){
    let pseudo = document.getElementById('pseudo').value;
    let password = document.getElementById('password').value;
    let data = new FormData();
    data.append('pseudo', pseudo);
    data.append('password', password);

    fetch('/api/ConnexionClient', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data === 'Connexion réussie'){
            ThrowAlertPopup(data,'succes');
            setTimeout(() => {
                let url = window.location.href;
                window.location.href = url;
            }, 1000);
        }else{
            let inputs = document.querySelectorAll('#connexionModal .modal-content #connexionForm input');
            console.log(inputs);

            if (inputs.length > 0) {
                inputs[0].classList.add('error');
            }
            if (inputs.length > 1) {
                inputs[1].classList.add('error');
            }

            ThrowAlertPopup(data,'error');

            setTimeout(() => {
                inputs[0].classList.remove('error');
                inputs[1].classList.remove('error');
            }
            , 2000);
        }
    });
}

function ThrowAlertPopup(message, type) {
    const existingAlert = document.getElementsByClassName('alert-popup');
    if (existingAlert.length > 0) {
        existingAlert[0].remove();
    }

    const alertPopup = document.createElement('div');
    alertPopup.className = 'alert-popup';

    let val;
    if (type === 'error') {
        val = 'Erreur';
    } else if (type === 'succes') {
        val = 'Succès';
    } else {
        console.error('Invalid type specified for alert popup.');
        return;
    }

    alertPopup.innerHTML = `
        <div class="alert-popup-content ${type}">   
            <span class="titre">${val}</span>
            <p>${message}</p>
        </div>
    `;

    document.body.appendChild(alertPopup);
    setTimeout(() => {
        alertPopup.remove();
    }, 5000);
}



function CreateConnexionModal() {
    // Remove existing modals if they exist
    if (document.getElementById('connexionModal') != null) {
        document.getElementById('connexionModal').remove();
    } else if (document.getElementById('inscriptionModal') != null) {
        document.getElementById('inscriptionModal').remove();
    }
    
    // Create the modal
    let modal = document.createElement('div');
    modal.id = 'connexionModal';
    modal.className = 'modal exception';
    modal.innerHTML = `
    <div class="modal-content">
        <span class="fermer">&times;</span>   
        <h2>Connexion</h2>
        <div id="connexionForm">
            <input type="email" id="pseudo" name="pseudo" placeholder="JEANDUJAR01 ou Jean.Dujardin@gmail.com" required>
            <input type="password" id="password" name="password" placeholder="*********" required>
            <button id="Connexion" onclick="Connexion()">Se connecter</button>
        </div>
        <p>Vous n'avez pas de compte ? <span id="inscription" onclick="">Inscrivez-vous</span></p>
    </div>
    `;
    document.body.appendChild(modal);

    // Apply blur to all elements except the modal
    Array.from(document.body.children).forEach(child => {
        if (child !== modal) {
            child.classList.add('blur');
        }
    });

    // Remove the modal when the close button is clicked
    let span = document.getElementsByClassName('fermer')[0];
    span.onclick = function() {
        modal.remove();
        Array.from(document.body.children).forEach(child => {
            child.classList.remove('blur');
        });
    };
}

function CreateInscriptionModal() {
    // Remove existing modals if they exist
    if (document.getElementById('inscriptionModal') != null) {
        document.getElementById('inscriptionModal').remove();
    } else if (document.getElementById('connexionModal') != null) {
        document.getElementById('connexionModal').remove();
    }
    
    // Create the modal
    let modal = document.createElement('div');
    modal.id = 'inscriptionModal';
    modal.className = 'modal exception';
    modal.innerHTML = `
    <div class="modal-content">
        <span class="fermer">&times;</span>   
        <h2>Inscription</h2>
        <form id="inscriptionForm">
            <label for="email">Email :</label>
            <!-- Add other form fields as needed -->
        </form>
    </div>
    `;
    document.body.appendChild(modal);

    // Apply blur to all elements except the modal
    Array.from(document.body.children).forEach(child => {
        if (child !== modal) {
            child.classList.add('blur');
        }
    });

    // Remove the modal when the close button is clicked
    let span = document.getElementsByClassName('fermer')[0];
    span.onclick = function() {
        modal.remove();
        Array.from(document.body.children).forEach(child => {
            child.classList.remove('blur');
        });
    };
}


function Deconnexion() {
    sessionStorage.removeItem('User');
    window.location.href = '/Deconnexion';
}

