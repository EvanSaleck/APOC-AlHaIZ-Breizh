<?php 

namespace Controllers\Front;

include_once 'Controllers/Front/Logement.php';

use Controllers\Front;

class Logement {
        
    public function getAllLogements() {

        
        
        return $logements;
    }
        
    public function getLogementById($id) {

            
        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }    
}