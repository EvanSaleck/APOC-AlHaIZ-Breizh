<?php
// Inlcude des controllers
include_once './Controllers/Front/LogementController.php';
include_once './Controllers/Front/ReservationController.php';

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
    case '/logement':
    case '/logement/':
        include './Views/Front/logement/detailsLogement.php';
        break;

    // Routes des API
    case '/api/getLogements':
        header('Content-Type: application/json');
        echo $logementController->getAllLogements();
        break;
    case '/api/getLogementsDataForCards':
        header('Content-Type: application/json');
        echo $logementController->getLogementsDataForCards();
        break;

    case '/api/getReservations':
    case 'api/getReservations':
        header('Content-Type: application/json');
        echo $reservationController->getAllReservations();
        break;
    
    case preg_match('/^\/api\/getLogementDataById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $logement_id = end($url_parts);

        header('Content-Type: application/json');
        echo $logementController->getLogementDataById($logement_id);
        break;
        
        // if ($logementController->logementExists($logement_id)) {
        //     echo 'Logement n°' . $logement_id . ' trouvé !';
        // }
        // else { 
        //     http_response_code(404);
        //     echo "Logement non trouvé";
        // }
        break;

        case preg_match('/^\/api\/getAmenagementsOfLogementById\/\d+$/', $requestUrl) ? true : false:
            $url_parts = explode('/', $requestUrl);
            $logement_id = end($url_parts);
    
            header('Content-Type: application/json');
            echo $logementController->getAmenagementsOfLogementById($logement_id);
            break;
            
            // if ($logementController->logementExists($logement_id)) {
            //     echo 'Logement n°' . $logement_id . ' trouvé !';
            // }
            // else { 
            //     http_response_code(404);
            //     echo "Logement non trouvé";
            // }
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
