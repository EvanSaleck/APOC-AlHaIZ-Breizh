<?php

namespace Controllers\Back;

include_once 'Service/Database.php';
include_once 'Models/Reservation.php';

use Service\Database;

use Models\Reservation;

class ReservationController {

    private $reservations;

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
}
