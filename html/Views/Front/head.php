
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Feuilles de style -->
    <link rel="stylesheet" href="../../assets/SCSS/general.css" type="text/css">

    <!-- Images -->
    <link rel="icon" type="image/png" size="32x32" href="../../assets/imgs/icons.png">

    <!-- Scripts -->
    <script src="../../assets/JS/header.js"></script>

    <?php
    $pageName = str_replace(".php", "", basename($_SERVER['PHP_SELF']));
    ?>
    <link rel="stylesheet" href="../../assets/SCSS/<?php echo $pageName; ?>.css" type="text/css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let path = window.location.pathname.split("/");
            let page = path.slice(-1)[0];

            switch (page) {
                case "index.php":
                    document.querySelector("head").innerHTML += '<title>Réservation</title>';
                    break;
                default:
                    document.querySelector("head").innerHTML += `<title>${page.replace('.php', '')}</title>`;
                    break;
            }
        });
    </script>
</head>




<?php
$_SESSION['user'] = [
    'nom' => 'Jean',
    'prenom' => 'Dupont',
    'url' => '/html/assets/imgs/Profils/user.png'
    ];

 if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    ?> <script>sessionStorage.setItem('User', JSON.stringify(<?php echo json_encode($user);?>));</script>
<?php } ?>

<body>
    <div class="HeaderContainer">
        <div class="Logo">
            <a href="./index.php">
                <img src="../../assets/imgs/logo.png" alt="Logo">
                <p>AlHaIZ Breizh</p>
            </a>
        </div>
        <div class="Menu">
            <ul>
                <li><a href="/APOC-AlHaIZ-Breizh/html/Views/Front/index.php">Accueil</a></li>
                <li><a href="/APOC-AlHaIZ-Breizh/html/Views/Front/about.php">A propos</a></li>
            </ul>
            <div id="account"></div>
        </div>
    </div>
</body>

<div id="ModalHovered">

</div>


</html>