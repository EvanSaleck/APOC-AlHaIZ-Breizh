<?php

namespace Controllers;

include_once 'Models/AbonnementICal.php';
include_once 'Service/ICalService.php';

use Models\AbonnementICal;
use Service\ICalService;
use \Exception;

class AbonnementICalController {
    private $abonnementICal;
    private $icalService;

    public function __construct() {
        $this->abonnementICal = new AbonnementICal();
        $this->icalService = new ICalService();
    }

    /**
     * Créer un nouvel abonnement
     */
    public function newAction($id) {
        $titre = $_POST['titreAbo'];
        $dateDebut = $_POST['dateDebut'];
        $dateFin = $_POST['dateFin'];
        $listeLogements = $_POST['logements'];

        // on renvoie une exception si la liste des logements est vide
        if (empty($listeLogements)) {
            throw new Exception('Il faut choisir au moins un logement');
        }

        $abonnement = new AbonnementICal($titre, $dateDebut, $dateFin, $listeLogements);

        header('Content-Type: application/json');
        echo json_encode($abonnement->newAbonnement($id));
    }

    /**
     * Editer un abonnement
     */
    public function editAction($id) {
        $titre = $_POST['titreAbo'];
        $dateDebut = $_POST['dateDebut'];
        $dateFin = $_POST['dateFin'];
        $listeLogements = $_POST['logements'];

        $abonnement = new AbonnementICal($titre, $dateDebut, $dateFin, $listeLogements);

        header('Content-Type: application/json');
        echo json_encode($abonnement->editAbonnement($id));
    }

    /**
     * Supprimer un abonnement
     */
    public function deleteAction($id) {
        header('Content-Type: application/json');
        echo json_encode($this->abonnementICal->deleteAbonnement($id));
    }

    /**
     * Récupérer les données d'un abonnement
     */
    public function getDataICal($id) {
        $abonnement = $this->abonnementICal->getAbonnementById($id);

        header('Content-Type: application/json');
        echo json_encode($abonnement);
    }

    /**
     * Récupérer les abonnements d'un propriétaire
     */
    public function getAbonnementsICalByProprietaire($id) {
        $abonnementFormat = $this->icalService->formatAbonnementTab($id);
        
        header('Content-Type: application/json');
        echo json_encode($abonnementFormat);
    }

    /**
     * Exporter un abonnement en fichier iCal
     */
    public function exportIcal($token) {
        $this->icalService->generateFileWithToken($token);
        $url = $this->icalService->urlFromToken($token);

        // echo $url;
        header('Location: ' . $url);
    }
}