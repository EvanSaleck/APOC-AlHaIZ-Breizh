<?php

namespace Controllers;

include_once 'Models/Logement.php';
include_once 'Service/FormNewLogement.php';

use Models\Logement;
use Service\FormNewLogement;
use \Exception;

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

    public function getLogementsByProprietaireId($id) {
        $logements = $this->logement->getLogementsByProprietaireId($id);

        header('Content-Type: application/json');

        echo json_encode($logements);
    }
        
    public function getLogementById($id) {
            
        $logement = $this->logement->getLogementById($id);
                    
        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }  
    
    public function updateStatus($id, $status){
        $logement = $this->logement->updateStatutLogement($id, $status);

        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }
    public function getLogementsDataForCards() {
        $dataLogements = $this->logement->getLogementsDataForCards();

        header('Content-Type: application/json');

        echo json_encode($dataLogements);
    }

    public function getLogementDataById($id) {
        $logement = $this->logement->getLogementCompleteByID($id);

        header('Content-Type: application/json');

        echo json_encode($logement);
    }

    public function getAmenagementsOfLogementById($id) {
        $amenagements = $this->logement->getAmenagementsOfLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($amenagements);
    }

    public function processFormNewLogement() { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $tabNomRue = explode(' ', htmlentities($_POST['nom_rue']));
            if(is_numeric($tabNomRue[0])) {
                $numeroRue = $tabNomRue[0];
                $nomRue = '';
                for ($i = 1; $i < count($tabNomRue); $i++) {
                    $nomRue .= $tabNomRue[$i] . ' ';
                } 
            } else {
                $numeroRue = null;
                $nomRue = htmlentities($_POST['nom_rue']);
            }

            $photo = null;

            $formLogement = new FormNewLogement(
                htmlentities($_POST['titre']),
                htmlentities($_POST['tarif']),
                $nomRue,
                htmlentities($_POST['ville']),
                htmlentities($_POST['cp']),
                $photo,
                htmlentities($_POST['amenagements']),
                htmlentities($_POST['surface']),
                htmlentities($_POST['nbPersMax']),
                htmlentities($_POST['nbChambres']),
                htmlentities($_POST['nbLitsSimples']),
                htmlentities($_POST['nbLitsDoubles']),
                htmlentities($_POST['type']),
                htmlentities($_POST['categorie']),
                htmlentities($_POST['pays']),
                htmlentities($_POST['etat'])
            );

            $formLogement->setNotRequiredFields(
                $numeroRue,
                (isset($_POST['complement_adresse']) ? htmlentities($_POST['complement_adresse']) : ''),
                (isset($_POST['accroche']) ? htmlentities($_POST['accroche']) : ''),
                (isset($_POST['description']) ? htmlentities($_POST['description']) : ''),
                (isset($_POST['delaiResaArrivee']) ? htmlentities($_POST['delaiResaArrivee']) : ''),
                (isset($_POST['dureeMinLoc']) ? htmlentities($_POST['dureeMinLoc']) : ''),
                (isset($_POST['delaiAnnulMax']) ? htmlentities($_POST['delaiAnnulMax']) : '')
            );     
            
            header('Content-Type: application/json');

            try {
                $formLogement->insert();
                echo json_encode('true');
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'uniquement accessible avec la methode POST']);
        }
    }
    
        
}