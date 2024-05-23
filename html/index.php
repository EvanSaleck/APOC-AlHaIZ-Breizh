<?php
// Inlcude des controllers
include_once './Controllers/Front/LogementController.php';
include_once './Controllers/Back/ReservationController.php';
include_once './Controllers/Front/UtilisateurController.php';

// Use des controllers
use Controllers\Front\LogementController;
use Controllers\Back\ReservationController;
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

    case '/Back/':
    case 'Back/':
        include_once('Views/Back/reservation/listeReservations.php');
    break;

    case '/Back/reservation/':
    case '/Back/reservation':
        include_once('Views/Back/reservation/listeReservations.php');
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
        //$reservationController->getAllReservation();
        $idProp = 7;
        $reservationController->getReservationByOwnerId(7);
        break;



        /*
        case preg_match('api\/getReservations\?idProprio=\d+', $requestUrl) ? true : false:

            $url_parts = explode('=', $requestUrl);
            $idProprio = end($url_parts);
            
            if ($reservationController->proprietaireExists($idProprio)) { echo 'Proprietaire n°' . $idProprio . ' trouvé !'; }
            else { 
                http_response_code(404);
                echo "Proprietaire non trouvé";
            }
            $reservationController->getReservationByOwnerId(7);
        */


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