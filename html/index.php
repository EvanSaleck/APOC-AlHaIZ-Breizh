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
    case '/compte':
        include './Views/Front/compte/detailsCompte.php';
        break;

    case '/api/getCompteClientDetails':
        // $idCompte = $_SESSION['client'];
        $idCompte = 1;
        $utilisateurController->getCompteClientDetails($idCompte);
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