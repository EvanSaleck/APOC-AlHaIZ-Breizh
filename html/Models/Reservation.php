<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;

    class Reservation {

        public function __construct() {
            $this->db = new Database();
        }

        public function getAllReservation() {
            $reservations = $this->db->executeQuery("SELECT * FROM reservation");
            return $reservations;
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
    }
?>