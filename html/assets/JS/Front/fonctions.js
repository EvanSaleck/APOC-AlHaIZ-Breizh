
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

function Inscription() {
    // Création d'un objet FormData pour recueillir les données du formulaire
    let data = new FormData();
    //let data = new FormData(document.querySelector('.nomduformulaire'));

    data.append('nom', "Dikapibara");
    data.append('prenom', "Léonard");
    data.append('civilite', "Mr");
    data.append('nomUtilisateur', "LéoKapibara");
    data.append('email', "leskapibaras@wanadoo.com");
    data.append('motDePasse', "jaimelesKapibaradu(22)");
    data.append('photoProfil', '/assets/imgs/Profils/jauni_daip.webp');
    data.append('dateNaissance', '07/08/1999');

    data.append('numero_rue', "12");
    data.append('nom_rue', "rue de Blancbois");
    data.append('code_postal', "22300");
    data.append('nom_ville', "Lannion");
    data.append('pays', "France");
    // const c_id_adresse, const code_client, const cc_id_adresse à générer ou à trouver sur d'autres tables

    // Appel API pour créer l'adresse et le compte utilisateur
    console.log('Envoi des données:', data);
    fetch('/api/inscriptionClient', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.success) {
            ThrowAlertPopup('Inscription réussie!', 'succes');
            setTimeout(() => {
                window.location.href = '/accueil';  // Redirection après l'inscription
            }, 1000);
        } else {
            ThrowAlertPopup('Erreur lors de l\'inscription: ' + data.error, 'error');
        }
    })
    .catch(error => {
        console.error('Erreur lors de l\'envoi:', error);
        ThrowAlertPopup('Erreur technique, veuillez réessayer plus tard.', 'error');
    });
}


// function Inscription() {
//     let data = new FormData();
//     fetch('/api/InscriptionClient', {
//         method: 'POST',
//         body: data
//     })
//     try {
//         // Ici, ajoutez la logique pour l'inscription
//         // Par exemple, récupérer les valeurs des champs de formulaire

//         // --------------------------- code en dur des valeurs pour l'instant ---------------------------
//         // const nom = document.getElementById('lastname').value;
//         // const prenom = document.getElementById('firstname').value;
//         // const civilite = document.getElementById('civility').value;
//         // const nomUtilisateur = document.getElementById('username').value;
//         // const email = document.getElementById('email').value;
//         // const motDePasse = document.getElementById('password').value;



//         // --------------------------- code en dur des valeurs pour l'instant ---------------------------
//         console.log('Nom:', nom);
//         console.log('Prénom:', prenom);
//         console.log('Civilité:', civilite);
//         console.log('Nom d\'utilisateur:', nomUtilisateur);
//         console.log('Email:', email);
//         console.log('Mot de passe:', motDePasse);
//         // Vous pouvez ajouter d'autres champs nécessaires à l'inscription

//         // Ensuite, envoyez ces valeurs à votre serveur pour créer un nouveau compte utilisateur
//         // Cela peut être fait via une requête AJAX, fetch API, ou autre méthode selon votre backend

//         console.log('Inscription réussie pour', nomUtilisateur);
//         return true;
//     } catch (error) {
//         console.error('Erreur lors de l\'inscription:', error);
//         return false;
//     }
// }


function ThrowAlertPopup(message,type) {
    if (document.getElementsByClassName('alert-popup').length > 0) {
        document.getElementsByClassName('alert-popup')[0].remove();
    }
    let alertPopup = document.createElement('div');
    alertPopup.className = 'alert-popup';
    val = null;
    if (type === 'error') {
        val = 'Erreur';
    } else if (type === 'succes') {
        val = 'Succès';
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
    <div class="modal-register-content">
        <span class="fermer">&times;</span>   
        <h2 class="desktop">Inscription</h2>
        
        <!-- -------------------------------- Mobile -------------------------------------- -->

        <div class="logoTitre mobile">
            <img src="assets/imgs/logo.webp" alt="Logo ALHaIZ Breizh">
            <h1>ALHaIZ Breizh</h1>
        </div>

         <!-- ------------------------------------------------------------------------------ -->

        <div class="container-creation-compte">
            <form class="formulaire-creation-compte" action="/" method="post">
                <div class="scroll">
                    <div id="lastname-form" class="form">
                        <label for="lastname">Nom :</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                    <div id="name-form" class="form">
                        <label for="firstname">Prénom :</label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>

                    <div id="civility-form" class="form">
                        <label for="civility">Civilité</label>
                        <select id="civility" name="civility">
                            <option value="unspecified">Non spécifié</option>
                            <option value="male">Monsieur</option>
                            <option value="female">Madame</option>
                        </select>
                    </div>
                    <div id="username-form" class="form">
                        <label for="username">Pseudonyme :</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div id="email-form" class="form">
                        <label for="email">Adresse mail :</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div id="password-form" class="form">
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                        <div id="password_error"></div>
                    </div>

                    <div id="confirm_password-form" class="form">
                        <label for="confirm_password">Confirmer mot de passe :</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <div id="confirm_password_error"></div>
                    </div>

                    <div id="agreement-form" class="form">
                        <div class="CGU-form">
                            <input type="checkbox" id="terms_conditions" name="terms_conditions" required>
                            <label for="terms_conditions">En cochant cette case, je confirme avoir lu et accepté les <a href="/terms-conditions">Conditions Générales d'Utilisation</a> d'ALHalIZ Breizh.</label>
                        </div>

                        <div class="CGV-form">
                            <input type="checkbox" id="sales_conditions" name="sales_conditions" required>
                            <label for="sales_conditions">En cochant cette case, je reconnais avoir lu et accepté les <a href="/sales-conditions">Conditions Générales de Vente</a> d'ALHalIZ Breizh.</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="registerButton">S'inscrire</button>
            </form>
            <button class="hasAccountButton">Déjà un compte ? Connectez-vous</button>
            <p class="hasAccountButton desktop">Déjà un compte ? <span id="inscription" onclick="Inscription()">Connectez-vous</span></p>
        </div>
    </div>

    `;
    
    document.body.appendChild(modal);

    const form = modal.querySelector('.formulaire-creation-compte');

    // Fonction pour gérer la soumission du formulaire
    function handleFormSubmit(event) {
        event.preventDefault(); // Prévenir le comportement par défaut (l'envoi du formulaire)

        // Appeler la fonction Inscription ici
        Inscription();

        // Vous pouvez récupérer les valeurs des champs du formulaire si nécessaire
        // const lastname = document.getElementById('lastname').value;
        // const firstname = document.getElementById('firstname').value;
        // ...
    }

    // Attacher l'événement de soumission du formulaire à la fonction handleFormSubmit
    form.addEventListener('submit', handleFormSubmit);

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
    // Verify if the password is correct and the same as the confirm password
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('confirm_password');
    function validatePassword() {
        var password = passwordInput.value;
        var confirmPassword = confirmPasswordInput.value;
        var passwordError = document.getElementById('password_error');
        var confirmPasswordError = document.getElementById('confirm_password_error');
        var errorMessage = '';
        var errorConfirmMessage = '';

        if (password.length > 0) {
            if (password.length < 8) {
                errorMessage += 'Le mot de passe doit contenir au moins 8 caractères.<br>';
            }
            if (!/[A-Z]/.test(password)) {
                errorMessage += 'Le mot de passe doit contenir au moins une lettre majuscule.<br>';
            }
            if (!/[a-z]/.test(password)) {
                errorMessage += 'Le mot de passe doit contenir au moins une lettre minuscule.<br>';
            }
            if (!/[0-9]/.test(password)) {
                errorMessage += 'Le mot de passe doit contenir au moins un chiffre.<br>';
            }
            if (!/[\W_]/.test(password)) {
                errorMessage += 'Le mot de passe doit contenir au moins un caractère spécial.<br>';
            }
            if ( (confirmPassword.length > 0) && ( passwordInput.value !== confirmPasswordInput.value)) {
                errorConfirmMessage += "Les mots de passe ne correspondent pas.";
            }
        }
        passwordError.innerHTML = errorMessage;
        confirmPasswordError.innerHTML = errorConfirmMessage;
    }
    
    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);
}


function Deconnexion() {
    sessionStorage.removeItem('User');
    window.location.href = '/Deconnexion';
}

