<?php

namespace Controllers\Front;

include_once 'Service/Database.php';

use Service\Database;

include_once 'Models/Reservation.php';

use Models\Reservation;

class ReservationController {
        
    public function getAllReservations(){
            
        $db = new Database();
        $reservations = $db->executeQuery('SELECT * FROM reservation');
            
        header('Content-Type: application/json');
            
        echo json_encode($reservations);
    }

    public function GetIdReservation($data){
        try {
            $id = $data['id'];
            $reservation = new Reservation();
            $return = $reservation->GetIdReservation($id);

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
            $reservation = new Reservation();
            $return = $reservation->getReservationById($id);

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