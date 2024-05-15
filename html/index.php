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
        appelFunction('indexAction');
        
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

function appelFunction($fonction) {
    if (function_exists($fonction)) {
        $fonction();
        exit;
    } else {
        http_response_code(500);
        echo "Erreur 500 - Fonction $fonction non trouvée";
    }
}
