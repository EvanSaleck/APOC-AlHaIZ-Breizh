<?php
// Inlcude des controllers
include './Controllers/Front/LogementController.php';
include './Controllers/Front/ReservationController.php';

// Use des controllers
use Controllers\Front\LogementController;
use Controllers\Front\ReservationController;

// Initialisation des controllers
$logementController = new LogementController();
$reservationController = new ReservationController();


$requestUrl = $_SERVER['REQUEST_URI'];
// $requestUrl = substr($requestUrl, 5);

switch($requestUrl) {
    // Routes des vues
    case '/':
    case '':
        include './Views/Front/logement/indexLogement.php';
        break;
    case preg_match('/^\/logement\/\d+$/', $requestUrl) ? true : false:
            $url_parts = explode('/', $requestUrl);
            $logement_id = end($url_parts);
            
            if ($logementController->logementExists($logement_id)) {
                echo 'Logement n°' . $logement_id . ' trouvé !';
            }
            else { 
                http_response_code(404);
                echo "Logement non trouvé";
            }
            break;

    // Routes des API
    case '/api/getLogements':
        $logementController->getAllLogements();
        break;
    case '/api/getLogementsDataForCards':
        $logementController->getLogementsDataForCards();
        break;

    case '/api/getReservations':
    case 'api/getReservations':
        $reservationController->getAllReservations();
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
    }
    else {
        http_response_code(500);
        echo "Erreur 500 - Fonction $fonction non trouvée";
    }
}
