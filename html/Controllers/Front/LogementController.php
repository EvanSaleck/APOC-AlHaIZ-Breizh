<?php

namespace Controllers\Front;

include_once 'Service/Database.php';
include_once 'Service/FormNewLogement.php';

use Service\Database;
use Service\FormNewLogement;
use \Exception;

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

    public function processFormNewLogement() { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $tabNomRue = explode(' ', $_POST['nom_rue']);
            $numeroRue = $tabNomRue[0];
            $nomRue = '';
            for ($i = 1; $i < count($tabNomRue); $i++) {
                $nomRue .= $tabNomRue[$i] . ' ';
            } 

            $photo = null;

            $formLogement = new FormNewLogement(
                $_POST['titre'],
                $_POST['tarif'],
                $nomRue,
                $_POST['ville'],
                $_POST['cp'],
                $_POST['pays'],
                $photo,
                $_POST['amenagements'],
                $_POST['surface'],
                $_POST['nbPersMax'],
                $_POST['nbChambres'],
                $_POST['nbLitsSimples'],
                $_POST['nbLitsDoubles'],
                $_POST['type'],
                $_POST['categorie']
            );

            $formLogement->setNotRequiredFields(
                $numeroRue,
                (isset($_POST['complement_adresse']) ? $_POST['complement_adresse'] : ''),
                (isset($_POST['etat']) ? $_POST['etat'] : ''),
                (isset($_POST['accroche']) ? $_POST['accroche'] : ''),
                (isset($_POST['description']) ? $_POST['description'] : ''),
                (isset($_POST['delaiResaArrivee']) ? $_POST['delaiResaArrivee'] : ''),
                (isset($_POST['dureeMinLoc']) ? $_POST['dureeMinLoc'] : ''),
                (isset($_POST['delaiAnnulMax']) ? $_POST['delaiAnnulMax'] : '')
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