<?php

namespace Controllers;

include_once 'Models/Reservation.php';
include_once 'Service/ICalService.php';

use Models\Reservation;
use Service\ICalService;
use \Exception;

class ReservationController {

    private $reservation;
    private $icalService;

    public function __construct() {
        $this->reservation = new Reservation();
        $this->icalService = new ICalService();
    }
     
    /**
     * Récupère toutes les réservations
     */
    public function getAllReservations(){
        $reservations = $this->reservation->getAllReservation();
            
        header('Content-Type: application/json');
            
        echo json_encode($reservations);
    }
        
    /**
     * Récupère les réservations d'un propriétaire
     */
    public function getReservationByOwnerId($id) {
        $reservationsProprietaire = $this->reservation->getReservationByOwnerId($id);
                    
        header('Content-Type: application/json');
            
        echo json_encode($reservationsProprietaire);
    }

    /**
     * Récupère les réservations par l'id d'un client
     */
    public function getReservationByClientId($id) {
        $reservationsClient = $this->reservation->getReservationByClientId($id);
                    
        header('Content-Type: application/json');
            
        echo json_encode($reservationsClient);
    }

    /**
     * Récupère le propriétaire d'une réservation par son id
     */
    public function getOwnerById($id) {
        $owner = $this->reservation->getOwnerById($id);
                    
        header('Content-Type: application/json');
            
        echo json_encode($owner);
    }

    /**
     * Verifie si une réservation existe
     */
    public function reservationExists($id) {
        $reservations = $this->reservation->reservationExists($id);
                    
        header('Content-Type: application/json');

        echo ($reservations ? 'true' : 'false');
    }

    /**
     * Verifie si un propriétaire existe
     */
    public function proprietaireExists($id) {
        $proprietaire = $this->reservation->proprietaireExists($id);
                    
        header('Content-Type: application/json');

        echo ($proprietaire ? 'true' : 'false');
    }

    /**
     * Enregistre une réservation
     */
    public function saveReservation($data, $idcpt){
        try{

            $return = $this->reservation->saveReservation($data, $idcpt);

            header('Content-Type: application/json');
            echo json_encode($return);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
            exit;
        }

    }

    /**
     * Renvoie la dernière réservation en fonction de la date d'arrivée et de la date de départ
     */
    public function getLastReservationfromDateDebutAndDateFin($data, $idcpt) {
        try {
            $date_arrivee = $data['date_arrivee'];
            $date_depart = $data['date_depart'];

            // $return = $this->reservation->getLastReservationfromDateDebutAndDateFin($date_arrivee, $date_depart);

            header('Content-Type: application/json');
            // echo json_encode($return);
        }
        catch (Exception $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
            exit;
        }
    }

    /**
     * Récupère une réservation par son id
     */
    public function getReservationById($data) {
        try {
            $id = $data['id'];
            $return = $this->reservation->getReservationById($id);

            header('Content-Type: application/json');
            echo json_encode($return);
        }
        catch (Exception $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
            exit;
        }
    }

    /**
     * Récupère des données d'une réservation par son id
     */
    public function getDataReservationById($id) {
        try {
            $return = $this->reservation->getDataReservationById($id);

            header('Content-Type: application/json');
            echo json_encode($return);
        }
        catch (Exception $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
            exit;
        }
    }
}