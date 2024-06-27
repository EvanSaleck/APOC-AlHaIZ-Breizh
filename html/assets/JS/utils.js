var starFull = '<img class="noteEtoile" src="/assets/imgs/notes/star_full.svg" alt="">';
var starEmpty = '<img class="noteEtoile" src="/assets/imgs/notes/star_empty.svg" alt="">';
var starHalf = '<img class="noteEtoile" src="/assets/imgs/notes/star_half.svg" alt="">';

export function displayNoteEtoiles(div,note) {
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

export async function fileExists(path) {
    try {
        const response = await fetch(path, { method: 'HEAD' });
        return response.ok;
    } catch (error) {
        console.error('Erreur:', error);
        return false;
    }
}

export function Connexion(typeConnexion){
    console.log(typeConnexion);
    
    let pseudo = document.getElementById('pseudo').value;
    let password = document.getElementById('password').value;

    let data = new FormData();
    data.append('pseudo', pseudo);
    data.append('password', password);

    let url = typeConnexion === 'proprio' ? '/api/ConnexionProprio' : '/api/ConnexionClient';

    fetch(url, {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if(data === 'Connexion réussie'){
            ThrowAlertPopup(data,'success');
            setTimeout(() => {
                if (typeConnexion === 'proprio') {
                    window.location.href = "/back/reservations";
                } else {
                    let url = window.location.href;
                    window.location.href = url;
                }
            }, 1000);
        } else if (data === "Identifiants incorrects"){
            // let inputs = document.querySelectorAll('#connexionModal .modal-content #connexionForm input');
            // console.log(inputs);

            // if (inputs.length > 0) {
            //     inputs[0].classList.add('error');
            // }
            // if (inputs.length > 1) {
            //     inputs[1].classList.add('error');
            // }
            // var div = document.getElementById('login_error');
            // div.innerHTML = data
            ThrowAlertPopup(data,'error');

            // setTimeout(() => {
            //     inputs[0].classList.remove('error');
            //     inputs[1].classList.remove('error');
            // }
            // , 2000);
        } else{
            let inputs = document.querySelectorAll('#connexionModal .modal-content #connexionForm input');
            console.log(inputs);

            if (inputs.length > 0) {
                inputs[0].classList.add('error');
            }
            if (inputs.length > 1) {
                inputs[1].classList.add('error');
            }
            var div = document.getElementById('login_error');
            div.innerHTML = data
            ThrowAlertPopup(data,'error');

            setTimeout(() => {
                inputs[0].classList.remove('error');
                inputs[1].classList.remove('error');
            }
            , 2000);
        }
    });
}

export function ThrowAlertPopup(message,type) {
    if (document.getElementsByClassName('alert-popup').length > 0) {
        document.getElementsByClassName('alert-popup')[0].remove();
    }
    let alertPopup = document.createElement('div');
    alertPopup.className = 'alert-popup';
    let imgSrc = null;
    if (type === 'error') {
        imgSrc = 'error.jpeg';
    } else if (type === 'success') {
        imgSrc = 'success.jpeg';
    }
    alertPopup.innerHTML = `
        <img src="/assets/imgs/alerts/${imgSrc}" alt=""> 
        <p>${message}</p>
    </div>
    `;
    document.body.appendChild(alertPopup);

    alertPopup.onclick = function() {
        alertPopup.remove();
    };
}

// ----------------------------------- Ajouts à garder -----------------------------------
export function Inscription() {
    // Création d'un objet FormData pour recueillir les données du formulaire
    let data = new FormData();
    // Récupération des valeurs des champs du formulaire

    const nom = document.getElementById('lastname').value;
    const prenom = document.getElementById('firstname').value;
    const civilite = document.getElementById('civility').value;
    const pseudo = document.getElementById('pseudo').value;
    const email = document.getElementById('email').value;
    const motDePasse = document.getElementById('password').value;
    const ddn = document.getElementById('ddn').value;
    const numero_rue = document.getElementById('numero_rue').value;
    const nom_rue = document.getElementById('nom_rue').value;
    const code_postal = document.getElementById('code_postal').value;
    const nom_ville = document.getElementById('nom_ville').value;
    const pays = document.getElementById('pays').value;
    const complement = document.getElementById('complement').value;
    const etat = document.getElementById('etat').value;

    data.append('nom', nom);
    data.append('prenom', prenom);
    data.append('civilite', civilite);
    data.append('pseudo', pseudo);
    data.append('email', email);
    data.append('password', motDePasse);
    data.append('photo_profil', '/assets/imgs/Profils/jauni_daip.webp');
    data.append('ddn', '1999-12-31');
    data.append('numero_rue', numero_rue);
    data.append('nom_rue', nom_rue);
    data.append('code_postal', code_postal);
    data.append('nom_ville', nom_ville);
    data.append('pays', pays);
    data.append('complement', complement);
    data.append('etat', etat);

    // Appel API pour créer l'adresse et le compte utilisateur
    for(var pair of data.entries()) {
        console.log(pair[0]+', '+pair[1]);
      }

    fetch('/api/InscriptionClient', {
        method: 'POST',
        body: data
    })
    .then(response => {
        console.log('response:', response);

        return response.json();
    })
    .then(data => {
        console.log(data);
        if (data === 'Inscription réussie') {
            console.log('Inscription réussie!');
            ThrowAlertPopup(data, 'succes');
            console.log('Redirection vers la page d\'accueil...');
            setTimeout(() => {
                Connexion()  // Redirection après l'inscription
            }, 1000);
        } else {
            var div = document.getElementById('register_error');
            div.innerHTML = data['Erreur : '];
            ThrowAlertPopup(data['Erreur : '], 'error');
        }
    })
    .catch(error => {
        console.error('Erreur lors de l\'envoi:', error);
        ThrowAlertPopup('Erreur technique, veuillez réessayer plus tard.', 'error');
    });
}


export function CreateConnexionModal(typeConnexion) {
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
        <h2 class="desktop modalTitle">Connexion</h2>
        
        <!-- -------------------------------- Mobile -------------------------------------- -->
        
        <div class="logoTitre mobile">
            <img src="assets/imgs/logo.webp" alt="Logo ALHaIZ Breizh" class="mobile">
            <h1 class="mobile">ALHaIZ Breizh</h1>
        </div>

        <!-- ------------------------------------------------------------------------------ -->
        <div class="container-connexion-compte">
            <div id="email-form" class="form">
                <label for="email">Adresse mail :</label>
                <input type="email" id="pseudo" name="pseudo" placeholder="JEANDUJAR01 ou Jean.Dujardin@gmail.com" required>
            </div>

            <div id="password-form" class="form">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="*********" required>
                <div id="password_error"></div>
            </div>
            <button class="loginButton" id="Connexion" onclick="Connexion()">Se connecter</button>
            <div id="login_error"></div>
            <button class="needAccountButton" id="Inscription">Vous n'avez pas de compte ? Inscrivez-vous</button>
        </div>
    </div>
    `;

    let connexion = modal.querySelector('#Connexion');
    connexion.addEventListener('click', () => {
        console.log('click');
        Connexion(typeConnexion);
    });


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

    let inscriptionButton = modal.querySelector('#Inscription');
    inscriptionButton.addEventListener('click', () => {
        CreateInscriptionModal();
    });
}

export function CreateInscriptionModal() {
    // Remove existing modals if they exist
    if (document.getElementById('inscriptionModal') != null) {
        document.getElementById('inscriptionModal').remove();
    } else if (document.getElementById('connexionModal') != null) {
        document.getElementById('connexionModal').remove();
    }

    document.body.classList.add('modal-open');
    // Create the modal
    let modal = document.createElement('div');
    modal.id = 'inscriptionModal';
    modal.className = 'modal exception';
    modal.innerHTML = `
    <div class="modal-register-content">
        <span class="fermer">&times;</span>   
        <h2 class="desktop modalTitle">Inscription</h2>
        
        <!-- -------------------------------- Mobile -------------------------------------- -->
        
        <div class="logoTitre mobile">
            <img src="assets/imgs/logo.webp" alt="Logo ALHaIZ Breizh" class="mobile">
            <h1 class="mobile">ALHaIZ Breizh</h1>
        </div>

         <!-- ------------------------------------------------------------------------------ -->

        <div class="container-creation-compte">
            <form class="formulaire-creation-compte" action="/" method="post">
                <div class="scroll">
                    <div id="lastname-form" class="form">
                        <label for="lastname">Nom :</label>
                        <input  type="text" id="lastname" name="lastname" required>
                    </div>
                    <div id="name-form" class="form">
                        <label for="firstname">Prénom :</label>
                        <input  type="text" id="firstname" name="firstname" required>
                    </div>

                    <div id="civility-form" class="form">
                        <label for="civility">Civilité</label>
                        <select  id="civility" name="civility">
                            <option value="unspecified">Non spécifié</option>
                            <option value="male">Monsieur</option>
                            <option value="female">Madame</option>
                        </select>
                    </div>
                    <div id="username-form" class="form">
                        <label for="username">Pseudonyme :</label>
                        <input  type="text" id="pseudo" name="username" required>
                    </div>
                    <div id="email-form" class="form">
                        <label for="email">Adresse mail :</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div id="password-form" class="form">
                        <label for="password">Mot de passe :</label>
                        <input type="password"  id="password" name="password" required>
                        <div id="password_error"></div>
                    </div>

                    <div id="confirm_password-form" class="form">
                        <label for="confirm_password">Confirmer mot de passe :</label>
                        <input type="password"  id="confirm_password" name="confirm_password" required>
                        <div id="confirm_password_error"></div>
                    </div>
                    
                    <!-- --------------------------------------------------------------- -->
                    <div id="ddn-form" class="form">
                        <label for="ddn">Date de naissance :</label>
                        <input type="date" id="ddn" name="ddn" required>
                    </div>

                    <div id="numero_rue-form" class="form">
                        <label for="numero_rue">Numéro de rue :</label>
                        <input type="text"  id="numero_rue" name="numero_rue" required>
                    </div>

                    <div id="nom_rue-form" class="form">
                        <label for="nom_rue">Nom de rue :</label>
                        <input type="text" id="nom_rue" name="nom_rue" required>
                    </div>

                    <div id="complement-form" class="form">
                        <label for="complement">Complément d'adresse :</label>
                        <input type="text" id="complement" name="complement">
                    </div>

                    <div id="code_postal-form" class="form">
                        <label for="code_postal">Code postal :</label>
                        <input type="text"  id="code_postal" name="code_postal" required>
                    </div>
                    
                    <div id="nom_ville-form" class="form">
                        <label for="nom_ville">Ville :</label>
                        <input type="text"  id="nom_ville" name="nom_ville" required>
                    </div>

                    <div id="pays-form" class="form">
                        <label for="pays">Pays :</label>
                        <input type="text"  id="pays" name="pays" required>
                    </div>

                    <div id="etat-form" class="form">
                        <label for="etat">État :</label>
                        <input type="text" id="etat" name="etat">
                    </div>
                    <!-- --------------------------------------------------------------- -->

                    <div id="agreement-form" class="form">
                        <div class="CGU-form">
                            <input  type="checkbox" id="terms_conditions" name="terms_conditions" required>
                            <label for="terms_conditions">En cochant cette case, je confirme avoir lu et accepté les <a href="/CGU_CGV">Conditions Générales d'Utilisation / de Vente</a> d'ALHaIZ Breizh.</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="registerButton">S'inscrire</button>
                <div id="register_error"></div>
            </form>
            <button class="hasAccountButton" id="Connexion">Déjà un compte ? Connectez-vous</button>
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

    //Apply blur to all elements except the modal
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
    let connexionButton = modal.querySelector('#Connexion');
    connexionButton.addEventListener('click', () => {
        CreateConnexionModal();
    });
}
// ----------------------------------- Ajouts à garder -----------------------------------

export function Deconnexion(type) {
    if(type === 'proprio'){
        sessionStorage.removeItem('Proprio');
        window.location.href = '/DeconnexionProprio/';
    } else if(type === 'user'){
        sessionStorage.removeItem('User');
        window.location.href = '/Deconnexion';
    }

}


export function resetErrors(){
    // reinitialiser les divs erreurs
    document.querySelectorAll('.error').forEach((el) => {
        el.classList.remove('error');
    });
    // reinitialiser les messages d'erreur
    document.querySelectorAll('.messageError').forEach((el) => {
        el.textContent = '';
    });
}

