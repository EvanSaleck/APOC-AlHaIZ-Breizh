<?php
session_start();
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
    // routes gildas
    case '/export/ical':
    case '/export/ical/':
        // $reservationController->exportIcal();
        include_once './Views/Back/reservation/exportICal.php';
        break;
    
    case '/service/exportICal':
    case '/service/exportICal/':
        $reservationController->exportIcal();
        break;
    
    // Routes des vues front office 
    case '/':
    case '':
        include_once './Views/Front/logement/indexLogement.php';
        break;
        
    case '/logement':
    case '/logement/':
        include_once './Views/Front/logement/detailsLogement.php';
        break;
    case '/compte':
        include_once './Views/Front/compte/detailsCompte.php';
        break;
    case '/reservation/devis':
    case '/reservation/devis/':
        if(!isset($_SESSION['client'])) { header('Location: /'); }
        else { include_once './Views/Front/reservation/devis.php'; }

        break;
        
    case '/Back/reservations':
    case '/Back/reservations/':
        include_once('Views/Back/reservation/listeReservations.php');
        if(!isset($_SESSION['proprio'])) {
            include_once('Views/Back/reservation/listeReservations.php');
            // header('Location: /');
        }
        else { include_once('Views/Back/reservation/listeReservations.php'); }
        break;
    case '/Back/reservations/details':
    case '/Back/reservations/details/':
        include_once('Views/Back/reservation/detailsReservation.php');
        if(!isset($_SESSION['proprio'])) {
            include_once('Views/Back/reservation/detailsReservation.php');
            // header('Location: /');
        }
        else { include_once('Views/Back/reservation/detailsReservation.php'); }
        break;

    // routes du back
    case '/logement/new':
    case '/logement/new/':
         if(!isset($_SESSION['proprio'])) {
            include './Views/Back/logement/newLogement.php';
        }else {
            header('Location: /');
        }
        break;
    
    // routes back office
    case '/logement':
    case '/logement/':
        include './Views/Back/logement/listeLogements.php';
        break;
    case '/logements/details':
    case '/logements/details/';
        include './Views/Back/logement/detailsLogement.php';
        break;
    case '/api/getLogementsDataForCards':
        header('Content-Type: application/json');
        echo $logementController->getLogementsDataForCards();
        break;
    
    case '/api/processFormNewLogement/':
    case '/api/processFormNewLogement':
        $logementController->processFormNewLogement();
        break;
    


        

    case '/api/getReservations':
    case 'api/getReservations':
        //$reservationController->getAllReservation();
        $idProp = 12;
        $reservationController->getReservationByOwnerId(11);
        break;
    // Juste besoin pour tester, à enlever pour merge avec getProprioById
    case '/api/getOwnerById':
    case 'api/getOwnerById':
        $data = $_POST;
        $reservationController->getOwnerById(11);
        break;





    case '/api/getReservationById':
    case 'api/getReservationById':
        $data = $_POST;
        $reservationController->getReservationById($data);
        break;
    case '/api/getProprioById':
    case 'api/getProprioById':
        $data = $_POST;
        $utilisateurController->getProprioById($data['id']);
        break;
    case '/api/getLogementById':
    case 'api/getLogementById':
        $data = $_POST;
        $logementController->getLogementById($data['id']);
        break;

    case '/api/getLogementsByProprietaireId':
    case '/api/getLogementsByProprietaireId/':
        // $data = $_POST;
        $data['id'] = 8 ; 
        $logementController->getLogementsByProprietaireId($data['id']);
        break;

    // Routes des API
    case '/Deconnexion':
    case 'Deconnexion':
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

    case '/api/getCompteClientDetails':
        // $idCompte = $_SESSION['client'];
        $client = json_decode($_SESSION['client']);
        $idCompte = $client->id_compte;
        $utilisateurController->getCompteClientDetails($idCompte);
        break;

    case '/api/getCompteClientDetailsBack':
        $data = $_POST;
        $utilisateurController->getCompteClientDetails($data['id']);
        break;

    case '/api/getReservations/all':
    case 'api/getReservations/all/':
        $reservationController->getAllReservations();
        break;
    case '/api/insertReservation':
    case '/api/insertReservation/':
        $data = $_POST;
        $client = json_decode($_SESSION['client']);
        $idcpt = $client->id_compte;
        $reservationController->saveReservation($data, $idcpt);
        break;

    case '/detailReservation':
    case '/detailReservation/':
        if(!isset($_SESSION['client'])) {
            header('Location: /');
        }else {
            include './Views/Front/reservation/DetailReservation.php';
        }
        break;

    case '/api/updateLogementStatus':
    case '/api/updateLogementStatus/':
        $id = $_POST['logementId'];
        $status = $_POST['status'];
        // var_dump($data);
        // die();
        $logementController->updateStatus($id, $status);
        break;
            

    
    case preg_match('/^\/api\/getLogementDataById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $logement_id = end($url_parts);

        $logementController->getLogementDataById($logement_id);
        break;

    case preg_match('/^\/api\/getAmenagementsOfLogementById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $logement_id = end($url_parts);

        echo $logementController->getAmenagementsOfLogementById($logement_id);
        break;

    default:
        http_response_code(404);
        echo "Erreur 404 - Page non trouvée";
        // echo "BAHAHAHAH 404 CHHHEEHHH";
        exit;
}