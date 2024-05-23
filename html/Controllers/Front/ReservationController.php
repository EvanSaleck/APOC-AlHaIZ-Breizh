<?php

namespace Controllers\Front;

include_once 'Service/Database.php';

use Service\Database;

class ReservationController {
        
    public function getAllReservations(){
            
        $db = new Database();
        $reservations = $db->executeQuery('SELECT * FROM reservation');
            
        header('Content-Type: application/json');
            
        echo json_encode($reservations);
    }
}