<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;

    class Facture {
        private $db;
        private $pdo;

        public function __construct() {
            $this->db = new Database();
            $this->pdo = $this->db->getPDO();
        }

        public function getFactureByResId($id) {
            $facture = $this->db->executeQuery("
                SELECT * 
                FROM facture 
                INNER JOIN reservation ON id_reservation = f_id_reservation
                INNER JOIN logement AS l ON l.id_logement = reservation.r_id_logement 
                INNER JOIN adresse AS adresseLogement ON adresseLogement.id_adresse = l_id_adresse
                WHERE id_reservation = ". $id);

            return $facture;
        }

        public function isAllowed($idFacture,$idCompte) {
            $facture = $this->db->executeQuery("
                SELECT id_facture
                FROM facture
                INNER JOIN reservation ON id_reservation = f_id_reservation
                INNER JOIN logement AS l ON l.id_logement = reservation.r_id_logement
                WHERE id_facture = ".$idFacture." AND (r_id_compte = ".$idCompte." OR l_id_compte = ".$idCompte.")"
            );

            return !empty($facture);
        }
    }
?>