<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;
    use Exception;

    class Reservation {
        private $db;

        private $pdo;


        public function __construct() {
            $this->db = new Database();

            $this->pdo = $this->db->getPDO();
        }

        public function getAllReservations(){
            
            $reservations = $this->db->executeQuery('SELECT * FROM reservation');
                
            header('Content-Type: application/json');
                
            return $reservations;
        }
      
        public function getReservationById($id) {

            $query = "SELECT * FROM reservation WHERE id_reservation = ?";
            $statement = $this->pdo->prepare($query);
            $statement->execute([$id]);
    
            $resa = $statement->fetch(\PDO::FETCH_ASSOC);

            return $resa;
        }
        public function saveReservation($data, $idcpt){

            $query = "INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES (?, ?, ?, ?, ?, FALSE, ?, ?)";
    
            $statement = $this->pdo->prepare($query);
    
            $dateReservation = date('Y-m-d');

            $statement->execute([
                $data['Nbnuits'],        // nb_nuit
                $data['dateArrivee'],    // date_arrivee
                $data['dateDepart'],     // date_depart
                $data['NbOccupants'],    // nb_occupant
                $dateReservation,        // date_reservation
                $data['id_logement'],    // R_id_logement
                $idcpt                   // R_id_compte
            ]);
    
                    
            header('Content-Type: application/json');
                    
            return "Réussi";
        }
    }
