<?php
// Inlcude des controllers
include_once './Controllers/Front/LogementController.php';
include_once './Controllers/Front/ReservationController.php';
include_once './Controllers/Front/UtilisateurController.php';

// Use des controllers
use Controllers\Front\LogementController;
use Controllers\Front\ReservationController;
use Controllers\Front\UtilisateurController;

// Initialisation des controllers
$logementController = new LogementController();
$reservationController = new ReservationController();
$utilisateurController = new UtilisateurController();


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
    case '/Deconnexion':
    case 'Deconnexion':
        session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: /');
    break;
    case '/api/ConnexionClient':
    case 'api/ConnexionClient':
        $data = $_POST;
        $utilisateurController->connexionClient($data);
    break;
    case 'api/InscriptionClient':
    case '/api/InscriptionClient':
        $data = $_POST;
        $utilisateurController->inscriptionClient($data);
    break;
    case '/api/ConnexionProprio':
        case 'api/ConnexionProprio':
            $data = $_POST;
            $utilisateurController->connexionProprio($data);
        break;
        case 'api/InscriptionProprio':
        case '/api/InscriptionProprio':
            $data = $_POST;
            $utilisateurController->inscriptionProprio($data);
        break;
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