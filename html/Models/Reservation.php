<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;

    class Reservation {
        private $db;
        private $pdo;

        public function __construct() {
            $this->db = new Database();
            $this->pdo = $this->db->getPDO();
        }

        public function getAllReservation() {
            $reservations = $this->db->executeQuery("SELECT * FROM reservation");
            return $reservations;
        }

        public function getReservationById($id) {

            $query = "SELECT * FROM reservation WHERE id_reservation = ?";
            $statement = $this->pdo->prepare($query);
            $statement->execute([$id]);
    
            $resa = $statement->fetch(\PDO::FETCH_ASSOC);

            return $resa;
        }

        public function getReservationByOwnerId($id) {
            // l_id_compte représente l'ID du compte d'un propriétaire
            $reservations = $this->db->executeQuery("SELECT l.titre, r.date_arrivee, r.date_depart, r.tarif_total, c.pseudo FROM reservation AS r 
            INNER JOIN logement AS l ON id_logement = R_id_logement INNER JOIN compte_client AS c ON id_compte = R_id_compte
            WHERE l.id_logement = r.r_id_logement AND l.l_id_compte = " . $id);

            return $reservations;
        }

        public function reservationExists($id) {
            $reservation = $this->db->executeQuery("SELECT * FROM reservation WHERE id_reservation = " . $id);
            return count($reservation) > 0;
        }

        public function proprietaireExists($id) {
            $reservation = $this->db->executeQuery("SELECT * FROM compte_proprietaire WHERE id_compte = " . $id);
            return count($reservation) > 0;
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
                        
            return "Réussi";
        }
    }
?>