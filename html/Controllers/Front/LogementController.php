<?php

namespace Controllers\Front;

include_once 'Service/Database.php';

use Service\Database;

class LogementController {
        
    public function getAllLogements() {
            
        $db = new Database();
        $logements = $db->executeQuery('SELECT * FROM logement');
            
        header('Content-Type: application/json');
            
        echo json_encode($logements);
    }
        
    public function getLogementById($id) {
            
        $db = new Database();
        $logement = $db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
            
        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }    
}