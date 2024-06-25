<?php
session_start();
// Inlcude des controllers
include_once './Controllers/LogementController.php';
include_once './Controllers/ReservationController.php';
include_once './Controllers/UtilisateurController.php';
include_once './Controllers/AbonnementICalController.php';
include_once './Controllers/FactureController.php';


// Use des controllers
use Controllers\LogementController;
use Controllers\ReservationController;
use Controllers\UtilisateurController;
use Controllers\AbonnementICalController;
use Controllers\FactureController;


// Initialisation des controllers
$logementController = new LogementController();
$reservationController = new ReservationController();
$utilisateurController = new UtilisateurController();
$abonnementICalController = new AbonnementICalController();
$factureController = new FactureController();


$requestUrl = $_SERVER['REQUEST_URI'];
$prop = 11;

switch($requestUrl) {
    case preg_match('/^\/reservations\/abonnement\?token=[a-f0-9]{64}$/', $requestUrl) ? true : false:
        $token = $_GET['token'];
        $abonnementICalController->exportIcal($token);
        break;

    case '/reservations/abonnements/iCal/new':
    case '/reservations/abonnements/iCal/new/':
        $_SESSION['proprio'] = $prop;
        include_once './Views/Back/reservation/abonnementICal.php';
        break;
    
    case '/reservations/abonnements/liste':
    case '/reservations/abonnements/liste/':
        $_SESSION['proprio'] = $prop;
        include_once './Views/Back/reservation/listeAbonnementsICal.php';
        break;

    case '/api/getAbonnementsICalByProprietaire':
    case '/api/getAbonnementsICalByProprietaire/':
        $id = $_SESSION['proprio'];
        $abonnementICalController->getAbonnementsICalByProprietaire($prop);
        break;
    
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
    

    //////////////////////////////
    //                          //
    // ROUTES VUES FRONT OFFICE //////////////////////////////////////////////////////////////////////////////////////
    //                          //
    //////////////////////////////

    // Page de détails du compte d'un client
    case '/compte':
    case '/compte/':
        include_once './Views/Front/compte/detailsCompte.php';
        break;

    // Page principale Front
    case '/':
    case '':
        include_once './Views/Front/logement/indexLogement.php';
        break;
        
    // Page de détails d'un logement pour le client
    case '/logement':
    case '/logement/':
        include_once './Views/Front/logement/detailsLogement.php';
        break;
    
    case '/detailReservation':
    case '/detailReservation/':
        if(isset($_SESSION['client'])) {
            include './Views/Front/reservation/DetailReservation.php';
        }
        else { header('Location: /'); }
        break;

    case '/reservation/devis':
    case '/reservation/devis/':
        if(isset($_SESSION['client'])) {
            include_once './Views/Front/reservation/devis.php';
        }
        else { header('Location: /'); }
        break;



    /////////////////////////////
    //                         //
    // ROUTES VUES BACK OFFICE ///////////////////////////////////////////////////////////////////////////////////////
    //                         //
    /////////////////////////////

    // Page de détails du compte d'un propriétaire
    case '/back/detailsCompte':
    case '/back/detailsCompte/':
        include './Views/Back/compte/detailsCompte.php';
        break;

    // Page principale Back / Page de liste des réservations du propriétaire
    case '/Back/reservations':
    case '/Back/reservations/':
        if(isset($_SESSION['proprio'])) {
            include_once('Views/Back/reservation/listeReservations.php');
        }
        else { header('Location: /connexionProprietaire'); }
        break;
     
    // Page de détails d'une réservation pour le propriétaire
    case '/Back/reservations/details':
    case '/Back/reservations/details/':
        if(isset($_SESSION['proprio'])) {
            include_once('Views/Back/reservation/detailsReservation.php');
        }
        else { header('Location: /connexionProprietaire'); }
        break;

    // Page de liste des logements
    case '/logements':
    case '/logements/':
        if(isset($_SESSION['proprio'])) {
            include_once('Views/Back/logement/listeLogements.php');
        }
        else { header('Location: /connexionProprietaire'); }
        break;

    case '/logements':
    case '/logements/':
        include './Views/Back/logement/listeLogements.php';
        break;

    case '/logement':
    case '/logement/':
        include './Views/Back/logement/listeLogements.php';
        break;

    // Page de détails d'un logement
    case '/logements/details':
    case '/logements/details/';
        include './Views/Back/logement/detailsLogement.php';
        break;

    // Page de création d'un logement
    case '/logement/new':
    case '/logement/new/':
        if(isset($_SESSION['proprio'])) {
            include './Views/Back/logement/newLogement.php';
        }
        else { header('Location: /connexionProprietaire'); }
        break;
     
    // Page de modification d'un logement
    case '/logements/details/modifier':
    case '/logements/details/modifier';
        include './Views/Back/logement/modifierLogement.php';
        break;



    ///////////////////////
    //                   //
    // ROUTES POUR L'API /////////////////////////////////////////////////////////////////////////////////////////////
    //                   //
    ///////////////////////

    // Fonctions de connexion / inscription pour les clients
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
    
    // Fonction de déconnection pour les clients, renvoie sur la page principale Front
    case '/Deconnexion':
    case '/Deconnexion/':
        $_SESSION = array();
        session_destroy();
        header('Location: /');
        break;

    // Page de connexion pour les propriétaires
    case '/connexionProprietaire':
    case '/connexionProprietaire/':
        include './Views/Back/connexionProprietaire.php';
        break;
    
    // Fonctions de connexion / inscription pour les propriétaires
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

    // Fonction de déconnexion pour les propriétaires, renvoie sur la page de connexion Back
    case '/DeconnexionProprio':
    case '/DeconnexionProprio/':
        $_SESSION = array();
        session_destroy();
        header('Location: /connexionProprietaire');
        break;

    
    
    // FONCTIONS D'API POUR LES LOGEMENTS
    case '/api/getLogements':
        header('Content-Type: application/json');
        echo $logementController->getAllLogements();
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
        
    case '/api/getLogementById':
    case 'api/getLogementById':
        $data = $_POST;
        $logementController->getLogementById($data['id']);
        break;
                
    case '/api/getLogementsByProprietaireId':
    case '/api/getLogementsByProprietaireId/':
        // $data = $_POST;
        $logementController->getLogementsByProprietaireId($prop);
        break;



    // FONCTIONS D'API POUR LES RESERVATIONS
    case '/api/getReservationsClient':
    case 'api/getReservationsClient':
        $data = $_POST;
        $reservationController->getReservationByClientId($data['id']);
        break;

    case '/api/getReservationsProprietaire':
    case 'api/getReservationsProprietaire':
        $data = $_POST;
        $reservationController->getReservationByOwnerId($data['id']);
        break;

    // PLUS UTILISE, à supprimer pendant le merge final du Index.php
    case '/api/getReservations':
    case 'api/getReservations':
        $idProp = 7;
        $reservationController->getReservationByOwnerId($prop);
        break;

    case '/api/getReservationById':
    case 'api/getReservationById':
        $data = $_POST;
        $reservationController->getReservationById($data);
        break;



    case '/api/getClientById':
    case 'api/getClientById':
        $data = $_POST;
        $utilisateurController->getCompteClientDetails($data['id']);
        break;

    case '/api/getProprioById':
    case 'api/getProprioById':
        $data = $_POST;
        $utilisateurController->getProprioById($data['id']);
        break;
    
    case '/api/getCompteClientDetails':
        // $idCompte = $_SESSION['client'];
        $client = json_decode($_SESSION['client']);
        $idCompte = $client->id_compte;
        $utilisateurController->getCompteClientDetails($idCompte);
        break;

    case '/api/getCompteClientDetailsById':
        $data = $_POST;
        $utilisateurController->getProprioById($data['id']);
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


    // Page de gestion des tokens
    case '/gestionTokens':
    case '/gestionTokens/':
        include './Views/Back/compte/gestionTokens.php';
        break;

    // Récupération de tous les tokens d'un propriétaire
    case '/api/getAllTokenById':
    case '/api/getAllTokenById/':
        $proprio = json_decode($_SESSION['proprio']);
        $id = $proprio->id_compte;
        $utilisateurController->getAllTokenById($id);
        break;

    // Suppression d'un token d'un propriétaire
    case '/api/deleteToken/':
        case '/api/deleteToken':
        $data = $_POST;
        $utilisateurController->deleteToken($data);
        break;

    // Création d'un token pour un propriétaire
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

    case preg_match('/^\/api\/getFactureByResId\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $idResa = end($url_parts);

        echo $factureController->getFactureByResId($idResa);
        break;

    /*
    case preg_match('/^\/api\/getDataReservationById\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
        $idResa = end($url_parts);
        echo $reservationController->getDataReservationById($idResa);
        break;
    */

    case preg_match('/^\/facture\/\d+$/', $requestUrl) ? true : false:
        $url_parts = explode('/', $requestUrl);
    
        include_once './Views/facture.php';
            
        break;
    
    case '/test':
        echo '<script>window.open("/facture/1", "_blank")</script>';
        break;

    default:
        http_response_code(404);
        echo "Erreur 404 - Page non trouvée";
        // echo "BAHAHAHAH 404 CHHHEEHHH";
        exit;
}