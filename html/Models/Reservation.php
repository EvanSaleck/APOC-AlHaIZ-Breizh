<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;

    class Reservation {
        private $db;


        public function __construct() {
            $this->db = new Database();
        }

        public function getAllLogements() {
            $logements = $this->db->executeQuery('SELECT * FROM logement');
            
            return $logements;
        }
      
        public function getReservationById($id) {
            $db = new Database();
            $pdo = $db->getPDO();

            $query = "SELECT * FROM reservation WHERE id_reservation = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$id]);
    
            $resa = $statement->fetch(\PDO::FETCH_ASSOC);

            return $resa;
        }
    }
