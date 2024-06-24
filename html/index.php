<?php
session_start();
// Inlcude des controllers
include_once './Controllers/LogementController.php';
include_once './Controllers/ReservationController.php';
include_once './Controllers/UtilisateurController.php';
include_once './Controllers/AbonnementICalController.php';


// Use des controllers
use Controllers\LogementController;
use Controllers\ReservationController;
use Controllers\UtilisateurController;
use Controllers\AbonnementICalController;

// Initialisation des controllers
$logementController = new LogementController();
$reservationController = new ReservationController();
$utilisateurController = new UtilisateurController();
$abonnementICalController = new AbonnementICalController();


$requestUrl = $_SERVER['REQUEST_URI'];

switch($requestUrl) {
    case preg_match('/^\/reservations\/abonnement\?token=[a-f0-9]{64}$/', $requestUrl) ? true : false:
        $token = $_GET['token'];
        $abonnementICalController->exportIcal($token);
        break;

    case '/reservations/abonnements/iCal/new':
    case '/reservations/abonnements/iCal/new/':
        $_SESSION['proprio'] = 7;
        include_once './Views/Back/reservation/abonnementICal.php';
        break;
    
    case '/reservations/abonnements/liste':
    case '/reservations/abonnements/liste/':
        include_once './Views/Back/reservation/listeAbonnementsICal.php';
        break;

    case '/api/getAbonnementsICalByProprietaire':
    case '/api/getAbonnementsICalByProprietaire/':
        $id = $_SESSION['proprio'];
        $abonnementICalController->getAbonnementsICalByProprietaire(7);
        break;
    
    case '/api/reservations/abonnements/iCal/new':
    case '/api/reservations/abonnement/iCal/new/':
        $abonnementICalController->newAction();        
        break;

    case preg_match('/^\/api\/reservations\/abonnements\/iCal\/edit\/\d+$/', $requestUrl) ? true : false:   
    case preg_match('/^\/api\/reservations\/abonnements\/iCal\/edit\/\d+\/$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $id = end($url_parts);
        
        $abonnementICalController->editAction($id);
        break;

    
    // on créé la route de suppression : /api/reservations/abonnements/iCal/delete/{id}
    // ainsi que  : /api/reservations/abonnements/iCal/delete/{id}/
    case preg_match('/^\/api\/reservations\/abonnements\/iCal\/delete\/\d+$/', $requestUrl) ? true : false:   
    case preg_match('/^\/api\/reservations\/abonnements\/iCal\/delete\/\d+\/$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $id = end($url_parts);
        $abonnementICalController->deleteAction($id);
        break;
    
    case preg_match('/^\/reservations\/abonnements\/iCal\/edit\/\d+$/', $requestUrl) ? true : false:   
    case preg_match('/^\/reservations\/abonnements\/iCal\/edit\/\d+\/$/', $requestUrl) ? true : false:
        include_once './Views/Back/reservation/abonnementICal.php';
        break;

    case preg_match('/^\/api\/reservations\/abonnements\/iCal\/getDataICal\/\d+$/', $requestUrl) ? true : false:
    case preg_match('/^\/api\/reservations\/abonnements\/iCal\/getDataICal\/\d+\/$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $id = end($url_parts);
        $abonnementICalController->getDataICal($id);
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
    case '/compte/':
        include_once './Views/Front/compte/detailsCompte.php';
        break;
    case '/connexion':
    case '/connexion/':
        include_once './Views/Front/compte/connexionCompte.php';
        break;
    case '/reservation/devis':
    case '/reservation/devis/':
        if(!isset($_SESSION['client'])) {
            header('Location: /');
        }else {
            include_once './Views/Front/reservation/devis.php';
        }

        break;
        
    case '/Back/reservations':
    case '/Back/reservations/':
        include_once('Views/Back/reservation/listeReservations.php');
        if(!isset($_SESSION['proprio'])) {
            include_once('Views/Back/reservation/listeReservations.php');
            
        }else {
            header('Location: /');
        }
        break;

    case '/logements':
    case '/logements/':
        if(!isset($_SESSION['proprio'])) {
            include_once('Views/Back/logement/listeLogements.php');
        }else {
            header('Location: /');
        }
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

    case '/connexionProprietaire':
    case '/connexionProprietaire/':
        include './Views/Back/connexionProprietaire.php';
        break;
    case '/api/getLogementsDataForCards':
        header('Content-Type: application/json');
        echo $logementController->getLogementsDataForCards();
        break;
    
    case '/api/processFormNewLogement/':
    case '/api/processFormNewLogement':
        $logementController->processFormNewLogement();
        break;

    case '/api/processFormUpdateLogement/':
    case '/api/processFormUpdateLogement':
        $logementController->processFormUpdateLogement();
        break;
    
    case '/api/getReservations':
    case 'api/getReservations':
        //$reservationController->getAllReservation();
        $idProp = 7;
        $reservationController->getReservationByOwnerId(7);
        break;
    case '/api/getReservationById':
    case 'api/getReservationById':
        $data = $_POST;
        $reservationController->getReservationById($data);
        break;
        
    case 'api/getTypeOfLogementById/':
    case 'api/getTypeOfLogementById/':
        $data = $_POST;
        $logementController->getTypeOfLogementById($data);
        break;
    /*
    case 'api/getCategorieOfLogementById/':
    case 'api/getCategorieOfLogementById/':
        $data = $_POST;
        $logementController->getCategorieOfLogementById($data);
        break;
        */

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
    case '/Deconnexion/':
        $_SESSION = array();
        session_destroy();
        header('Location: /');
        break;
    
    case '/DeconnexionProprio':
        case '/DeconnexionProprio/':
            $_SESSION = array();
            session_destroy();
            header('Location: /connexionProprietaire');
            break;

    case '/back/detailsCompte':
        case '/back/detailsCompte/':
            include './Views/Back/compte/detailsCompte.php';
            break;
    case '/gestionTokens':
        case '/gestionTokens/':
            include './Views/Back/compte/gestionTokens.php';
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
        /*
    case '/api/getCategorieOfLogementById':
    case '/api/getCategorieOfLogementById/':
        $data = $_POST;
        $categorieLogement->getCategorieOfLogementById($data);
        break;
        */
    

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
    
    case '/api/getCompteProprioDetails':
        case '/api/getCompteProprioDetails/':
        $proprio = json_decode($_SESSION['proprio']);
        $idCompte = $proprio->id_compte;
        $utilisateurController->getCompteProprioDetails($idCompte);
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

    case '/api/getAllTokenById':
    case '/api/getAllTokenById/':
        $proprio = json_decode($_SESSION['proprio']);
        $id = $proprio->id_compte;
        $utilisateurController->getAllTokenById($id);
        break;

    case '/api/deleteToken/':
        case '/api/deleteToken':
        $data = $_POST;
        $utilisateurController->deleteToken($data);
        break;

    case '/api/generateToken':
    case '/api/generateToken/':
        $data = $_POST;
        $utilisateurController->generateToken($data);
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
    
    case preg_match('/^\/api\/getCategorieOfLogementById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $logement_id = end($url_parts);

        echo $logementController->getCategorieOfLogementById($logement_id);
        break;
    
    case preg_match('/^\/api\/getTypeOfLogementById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $logement_id = end($url_parts);

        echo $logementController->getTypeOfLogementById($logement_id);
        break;

    default:
        http_response_code(404);
        echo "Erreur 404 - Page non trouvée";
        // echo "BAHAHAHAH 404 CHHHEEHHH";
        exit;
}