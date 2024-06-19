<?php

namespace Controllers;

include_once 'Models/AbonnementICal.php';
include_once 'Service/ICalService.php';

use Models\AbonnementICal;
use Service\ICalService;

class AbonnementICalController {
    private $abonnementICal;
    private $icalService;

    public function __construct() {
        $this->abonnementICal = new AbonnementICal();
        $this->icalService = new ICalService();
    }

    public function newAction() {
        $dateDebut = $_POST['dateDebut'];
        $dateFin = $_POST['dateFin'];
        $listeLogements = $_POST['logements'];

        $abonnement = new AbonnementICal($dateDebut, $dateFin, $listeLogements);

        header('Content-Type: application/json');
        echo json_encode($abonnement->newAbonnement());
    }

    public function editAction($id) {
        $dateDebut = $_POST['dateDebut'];
        $dateFin = $_POST['dateFin'];
        $listeLogements = $_POST['logements'];

        $abonnement = new AbonnementICal($dateDebut, $dateFin, $listeLogements);

        header('Content-Type: application/json');
        echo json_encode($abonnement->editAbonnement($id));
    }

    public function deleteAction($id) {
        header('Content-Type: application/json');
        echo json_encode($this->abonnementICal->deleteAbonnement($id));
    }

    public function getDataICal($id) {
        $abonnement = $this->abonnementICal->getAbonnementById($id);

        header('Content-Type: application/json');
        echo json_encode($abonnement);
    }

    public function getAbonnementsICalByProprietaire($id) {
        $abonnementFormat = $this->icalService->formatAbonnementTab($id);
        
        header('Content-Type: application/json');
        echo json_encode($abonnementFormat);
    }
}