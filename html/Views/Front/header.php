<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Feuilles de style -->
    <link rel="stylesheet" href="/APOC-AlHaIZ-Breizh/SCSS/general.css" type="text/css">

    <!-- Images -->
    <link rel="icon" type="image/png" href="/assets/imgs/logo.png">

    <!--------------------------- Bootstrap 5 -------------------------->

    <?php 
        $pageName = str_replace(".php","",basename($_SERVER['PHP_SELF']));
    ?>
    <link rel="stylesheet" href="/APOC-AlHaIZ-Breizh/SCSS/<?php echo $pageName; ?>.css" type="text/css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let path = window.location.pathname.split("/");
            let page = path.slice(-1)[0];

            switch(page){
                case "index.php" :
                    document.querySelector("head").innerHTML += '<title>Réservation</title>';
                    document.querySelector("head").innerHTML += '<link rel="stylesheet" href="/APOC-AlHaIZ-Breizh/SCSS/index.css" type="text/css">';
                    break;
                default:
                    document.querySelector("head").innerHTML += `<title>${page.replace('.php', '')}</title>`;
                    break;
            }
        });
    </script>
</head>
<body>
    <div class="HeaderContainer">
        <div class="Header">
            <div class="Logo">
                <a href="/APOC-AlHaIZ-Breizh/Views/Front/index.php">
                    <img src="/assets/imgs/logo.png" alt="Logo">
                </a>
            </div>
            <div class="Menu">
                <ul>
                    <li><a href="/APOC-AlHaIZ-Breizh/Views/Front/index.php">Accueil</a></li>
                    <li><a href="/APOC-AlHaIZ-Breizh/Views/Front/booking.php">Réservation</a></li>
                    <li><a href="/APOC-AlHaIZ-Breizh/Views/Front/contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
</body>
</html>
