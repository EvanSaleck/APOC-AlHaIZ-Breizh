<?php

namespace Controllers\Front;

include_once 'Models/Utilisateur.php';

use Models\Utilisateur;

class UtilisateurController {

    private $user;

    public function __construct() {
        $this->user = new Utilisateur();
    }

    public function getCompteClientDetails($idCompte) {
        $dataCompteClient = $this->user->getCompteClientDetails($idCompte);
    
        header('Content-Type: application/json');
        echo json_encode($dataCompteClient);
    }
}