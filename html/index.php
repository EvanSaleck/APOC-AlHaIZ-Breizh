<?php

$requestUrl = $_SERVER['REQUEST_URI'];

// if (strpos($requestUrl, '.php') !== false) {
//     http_response_code(403); // Interdit
//     echo "Accès interdit";
//     exit;
// }

$requestUrl = substr($requestUrl, 5);

switch($requestUrl) {
    case '/':
    case '':
        include './Controllers/Front/LogementController.php';

        // Appel de la fonction indexAction si elle existe
        if (function_exists('indexAction')) {
            indexAction();
            exit;
        } else {
            // Gérer le cas où la fonction indexAction n'est pas définie
            http_response_code(500); // Erreur interne du serveur
            echo "Erreur 500 - Fonction indexAction non trouvée";
            exit;
        }
        break;
    case '/logement/edit':
        
        break;
    default:
        http_response_code(404);
        echo "BAHAHAHAH 404 CHHHEEHHH";
        exit;
}

// switch ($request) {
//     case '/' :
//     case '' :
//         require 'Views/Front/logement/index.php';
//         // require 'Views/Front/logement/edit.php';
//         break;
//     case '/logement/edit' :
//         require 'Views/Front/logement/edit.php';
//         break;
//     default:
//         http_response_code(404);
//         require 'Views/Front/404.php';
//         break;
// }
