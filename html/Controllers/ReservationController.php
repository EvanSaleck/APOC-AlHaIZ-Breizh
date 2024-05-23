<?php

namespace Controllers;

include_once 'Models/Reservation.php';

use Models\Reservation;
use \Exception;

class ReservationController {

    private $reservation;

    public function __construct() {
        $this->reservation = new Reservation();
    }
        
    public function getAllReservations(){
        $reservations = $this->reservation->getAllReservation();
            
        header('Content-Type: application/json');
            
        echo json_encode($reservations);
    }
        
    public function getReservationByOwnerId($id) {
        $reservations = $this->reservation->getReservationByOwnerId($id);
                    
        header('Content-Type: application/json');
            
        echo json_encode($reservations);
    }

    public function reservationExists($id) {
        $reservations = $this->reservation->reservationExists($id);
                    
        header('Content-Type: application/json');

        echo ($reservations ? 'true' : 'false');
    }

    public function proprietaireExists($id) {
        $proprietaire = $this->reservation->proprietaireExists($id);
                    
        header('Content-Type: application/json');

        echo ($proprietaire ? 'true' : 'false');
    }

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
}