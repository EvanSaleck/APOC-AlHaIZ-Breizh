<?php

namespace Controllers\Front;

include_once 'Service/Database.php';
include_once 'Models/Logement.php';

use Service\Database;
use Models\Logement;

class LogementController {
        
    public function getAllLogements() {
        $db = new Database();
        $result = $db->executeQuery('SELECT * FROM logement');

        $logements = [];
        if ($result !== false) {
            foreach ($result as $row) {
                $logements[] = new Logement(
                    $row['id_logement'], 
                    $row['titre'], 
                    $row['accroche'], 
                    $row['personnes_max'], 
                    $row['image_principale'], 
                    $row['description'], 
                    $row['latitude'], 
                    $row['longitude'], 
                    $row['surface_hab'], 
                    $row['nb_chambres'], 
                    $row['nb_lits_simples'], 
                    $row['nb_lits_doubles'], 
                    $row['prix_nuit_ht'], 
                    $row['prix_nuit_ttc'], 
                    $row['statut_propriete'], 
                    $row['duree_min_location'], 
                    $row['avance_resa_min'], 
                    $row['delai_annul_max'], 
                    $row['L_id_adresse'], 
                    $row['L_id_compte'], 
                    $row['L_id_type'], 
                    $row['L_id_categorie']
                );
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array_map(function($logement) {
            return $logement->toArray();
        }, $logements));
    }
        
    public function getLogementById($id) {
            
        $db = new Database();
        $logement = $db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
            
        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }    
}