<?php 

include_once 'Model/Logement.php';

use Model\Logement;

class LogementController{

    public function getLogementById($id) {
            
        $logement = new Logement();

        $getLogement = $logement->getLogementById($id);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(getLogementById);
    }
}
 