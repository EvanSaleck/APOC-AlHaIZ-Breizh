<?php
    include_once 'Service/Database.php';

    use Service\Database;

    class Logement {

        public function __construct() {
            $this->db = new Database();
        }

        public function getLogementById($id) {
            
            $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
                
            return $logement;
        }

        public function logementExists($id) {
            $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
            return count($logement) > 0;
        }
    }
    