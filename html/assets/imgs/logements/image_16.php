<?php
// Inlcude des controllers
include './Controllers/LogementController.php';
include './Controllers/ReservationController.php';

// Use des controllers
use Controllers\Front\LogementController;
use Controllers\Front\ReservationController;

// Initialisation des controllers
$logementController = new LogementController();
$reservationController = new ReservationController();


$requestUrl = $_SERVER['REQUEST_URI'];
// $requestUrl = substr($requestUrl, 5);

switch($requestUrl) {
    // Routes des vues front office
    case '/':
    case '':
        include_once 'Views/Front/logement/index.php';
        break;

    // Routes des API
    case '/api/getLogements':
    case 'api/getLogements':
        $logementController->getAllLogements();
        break;

    // routes back office
    case '/logement/new':
        include_once 'Views/Back/logement/newLogement.php';
        break;
    
    case '/api/getReservations':
    case 'api/getReservations':
        $reservationController->getAllReservations();
        break;
    case '/api/processFormNewLogement':
        $logementController->processFormNewLogement();
        break;

    default:
        http_response_code(404);
        echo "BAHAHAHAH 404 CHHHEEHHH";
        exit;
}