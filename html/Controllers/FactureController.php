<?php

namespace Controllers;

include_once 'Models/Facture.php';

use Models\Facture;

class FactureController {
    private $facture;

    public function __construct() {
        $this->facture = new Facture();
    }   

    public function getFactureByResId($id){
        $resFacture = $this->facture->getFactureByResId($id);
            
        header('Content-Type: application/json');
            
        echo json_encode($resFacture);
    }

    public function isAllowed($idFacture,$idCompte) {
        $allowed = $this->facture->isAllowed($idFacture,$idCompte);
            
        return $allowed;
    }

    public function createFacture() {
        $this->facture->createFacture();
    }
}