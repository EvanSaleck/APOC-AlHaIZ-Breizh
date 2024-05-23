<?php

namespace Controllers\Front;

include_once 'Models/Reservation.php';

use Models\Reservation;

use Exception;

class ReservationController {

    private $reservation;

    public function __construct() {
        $this->reservation = new Reservation();
    }
        
    public function getAllReservations(){
        try {
            $reservations = $this->reservation->getAllReservations();

            header('Content-Type: application/json');

            echo json_encode($reservations);
        }
        catch (Exception $e) {
            http_response_code(500);
            echo json_encode($e->getMessage());
            exit;
        }
    }

    public function GetIdReservation($data){
        try {
            $id = $data['id'];
            $return = $this->reservation->GetIdReservation($id);

            header('Content-Type: application/json');
            echo json_encode($return);
        }
        catch (Exception $e) {
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
}

