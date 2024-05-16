
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Feuilles de style -->
    <link rel="stylesheet" href="/html/assets/SCSS/general.css" type="text/css">

    <!-- Images -->
    <link rel="icon" type="image/png" size="32x32" href="/html/assets/imgs/logo.png">

    <!-- Scripts -->
    <script src="/html/assets/JS/header.js"></script>

    <?php

    function getPageNameFromPath($path) {
        return basename($path, ".php");
    }

    $pageName = str_replace(".php", "", basename($_SERVER['PHP_SELF']));

    $pagesIncluses = get_included_files();


    for ($i = 0; $i < count($pagesIncluses); $i++) {
        if (str_contains($pagesIncluses[$i], "Views/Front/")){
            $pageName = getPageNameFromPath($pagesIncluses[$i]);
            
            $cssPath = __DIR__ . "/html/assets/SCSS/" . $pageName . ".css";
            $jsPath = __DIR__ . "/html/assets/JS/" . $pageName . ".js";
    
            if (file_exists($cssPath)) {
                echo '<link rel="stylesheet" href="/html/assets/SCSS/' . $pageName . '.css" type="text/css">' . PHP_EOL;
            }
    
            if (file_exists($jsPath)) {
                echo '<script src="/html/assets/JS/' . $pageName . '.js"></script>' . PHP_EOL;
            }
        }
    }
    ?>

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
    
</head>


</html>