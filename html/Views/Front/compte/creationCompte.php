<?php
include_once 'Views/Front/composants/header.php';
include_once 'Views/Front/composants/head.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    
    });

</script>


<body>
    <main>
        <div class="logoTitre">
            <img src="assets/imgs/logo.webp" alt="Logo ALHaIZ Breizh">
            <h1>ALHaIZ Breizh</h1>
        </div>
        <div class="container-creation-compte">
            <form class="formulaire-creation-compte" action="/signup" method="post">
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
                            <label for="terms_conditions">En cochant cette case, je confirme avoir lu et accepté les <a href="/CGU_CGV">Conditions Générales d'Utilisation /de Ventes</a> d'ALHaIZ Breizh.</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="registerButton">S'inscrire</button>
            </form>
            <button class="hasAccountButton">Déjà un compte ? Connectez-vous</button>
        </div>
    </main>
</body>

<?php include_once 'Views/Front/composants/footer.php' ?>