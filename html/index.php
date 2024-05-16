<?php

$requestUrl = $_SERVER['REQUEST_URI'];

$requestUrl = substr($requestUrl, 5);

$routes = [
    '/' => 'indexAction',
    '/logement/edit' => 'editAction',
    '/header' => 'headerAction'
];

// if (array_key_exists($requestUrl, $routes)) {

//     appelFunction($routes[$requestUrl]);
// } else {
//     http_response_code(404);
//     echo "Erreur 404 - Page non trouvée";
// }

switch($requestUrl) {
    case '/':
    case '':
        // include 'Views/Front/logement/index.php';
        include './Controllers/Front/LogementController.php';
        appelFunction('indexAction');
        
        break;
    case '/logement/edit':
        
        break;
    case '/header':
        include './Views/Front/header.php';
        break;
    case '/api/getLogements':
        include './Controllers/Front/Api/LogementApiController.php';
        echo json_encode(appelFunction('indexAction')); 
        
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
