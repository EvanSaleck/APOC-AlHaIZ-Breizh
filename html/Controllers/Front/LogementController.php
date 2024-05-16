<?php

namespace Controllers\Front;

include 'Service/Database.php';

use Service\Database;

class LogementController {
        
        public function getAllLogements()
        {
            
            $db = new Database();
            $logements = $db->executeQuery('SELECT * FROM logement');
        
            // echo json_encode($logements);
            
            header('Content-Type: application/json');
            
            echo json_encode($logements);
        }
        
        public function getLogementById($id)
        {
            
            $db = new Database();
            $logement = $db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
        
            // echo json_encode($logements);
            
            header('Content-Type: application/json');
            
            echo json_encode($logement);
        }

        
}

function indextAction()
{
    
    $db = new Database();
    $logements = $db->executeQuery('SELECT * FROM logement');

    // echo json_encode($logements);
    
    header('Content-Type: application/json');
    
    echo json_encode($logements);
}