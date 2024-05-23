<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Feuilles de style -->
    <link rel="stylesheet" href="/assets/SCSS/Front/modal.css" type="text/css">
    <script src="/assets/JS/Front/fonctions.js"></script>
    
    <?php
        session_start();
        
        $pageName = str_replace(".php", "", basename($_SERVER['PHP_SELF']));
        
        $pagesIncluses = get_included_files();

        foreach ($pagesIncluses as $page) {
            $url = str_replace(".php", "", basename($page));

            $cheminCSS = "/assets/SCSS/Front/" . $url . ".css";
            $cheminJS = "/assets/JS/Front/" . $url . ".js";

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $cheminCSS)) {
                echo '<link rel="stylesheet" href="' . $cheminCSS . '" type="text/css">' . PHP_EOL;
            }

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $cheminJS)) {
                echo '<script src="' . $cheminJS . '"></script>' . PHP_EOL;
            }
        }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let path = window.location.pathname.split("/");
            let page = path.slice(-1)[0];
            switch (page) {
                case "":
                    document.querySelector("head").innerHTML += '<title>AlHAiZ Breizh</title>';
                    break;
                default:
                    document.querySelector("head").innerHTML += `<title>${page.replace('.php', '')}</title>`;
                    break;
            }
        });
    </script>

    <?php
    if (isset($_SESSION['client'])) {
        $user = $_SESSION['client'];
        ?>
        <script>
            sessionStorage.setItem('User', JSON.stringify(<?php echo $user; ?>));
        </script>
    <?php } ?>
</head>
