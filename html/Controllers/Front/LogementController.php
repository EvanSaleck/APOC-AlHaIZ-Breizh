<?php

namespace Controllers\Front;

include_once 'Models/Logement.php';

use Models\Logement;

class LogementController {

    private $logement;

    public function __construct() {
        $this->logement = new Logement();
    }
        
    public function getAllLogements() {            
        $logements = $this->logement->getAllLogements();
            
        header('Content-Type: application/json');
            
        echo json_encode($logements);
    }
        
    public function getLogementById($id) {
            
        $logement = $this->logement->getLogementById($id);
                    
        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }
    
    public function getLogementsDataForCards() {
        $dataLogements = $this->logement->getLogementsDataForCards();

        header('Content-Type: application/json');
        
        echo json_encode($dataLogements);
    }
    
    public function logementExists($id) {
        $logement = $this->logement->logementExists($id);

        header('Content-Type: application/json');

        echo ($logement ? 'true' : 'false');
    }
}