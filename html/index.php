<?php
// Inlcude des controllers
include './Controllers/Front/LogementController.php';

// Use des controllers
use Controllers\Front\LogementController;

// Initialisation des controllers
$logementController = new LogementController();



$requestUrl = $_SERVER['REQUEST_URI'];

$requestUrl = substr($requestUrl, 5);

switch($requestUrl) {
    // Routes des vues
    case '/':
    case '':
        include 'Views/Front/logement/index.php';
        break;

    // Routes des API
    case '/api/getLogements':
    case 'api/getLogements':
        $logementController->getAllLogements();
        break;
    default:
        http_response_code(404);
        echo "BAHAHAHAH 404 CHHHEEHHH";
        exit;
}

function appelFunction($fonction) {
    if (function_exists($fonction)) {
        $fonction();
        exit;
    } else {
        http_response_code(500);
        echo "Erreur 500 - Fonction $fonction non trouvée";
    }
}
