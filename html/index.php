<?php
// Inlcude des controllers
include_once './Controllers/LogementController.php';
include_once './Controllers/ReservationController.php';
include_once './Controllers/UtilisateurController.php';

// Use des controllers
use Controllers\LogementController;
use Controllers\ReservationController;
use Controllers\UtilisateurController;

// Initialisation des controllers
$logementController = new LogementController();
$reservationController = new ReservationController();
$utilisateurController = new UtilisateurController();


$requestUrl = $_SERVER['REQUEST_URI'];
// $requestUrl = substr($requestUrl, 5);

switch($requestUrl) {
    // Routes des vues front office
    case '/':
    case '':
        include './Views/Front/logement/indexLogement.php';
        break;
    case '/logement':
    case '/logement/':
        include './Views/Front/logement/detailsLogement.php';

    // routes back office
    case '/back/logements':
        include_once 'Views/Back/logement/listeLogement.php';
        break;
    case '/back/logement/new':
        include_once 'Views/Back/logement/newLogement.php';
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
    case 'api/InscriptionClient'://  include_once 'Views/Front/composants/footer.php';

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
    
    case preg_match('/^\/api\/getLogementDataById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $logement_id = end($url_parts);

        $logementController->getLogementDataById($logement_id);
        break;

    case preg_match('/^\/api\/getAmenagementsOfLogementById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $logement_id = end($url_parts);

        $logementController->getAmenagementsOfLogementById($logement_id);
        break;
        
        // if ($logementController->logementExists($logement_id)) {
        //     echo 'Logement n°' . $logement_id . ' trouvé !';
        // }
        // else { 
        //     http_response_code(404);
        //     echo "Logement non trouvé";
        // }
        break;
    case '/api/processFormNewLogement':
        $logementController->processFormNewLogement();
        break;

    default:
        http_response_code(404);
        echo "BAHAHAHAH 404 CHHHEEHHH";
        exit;
}