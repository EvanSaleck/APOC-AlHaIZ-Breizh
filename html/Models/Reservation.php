<?php
    include_once 'Service/Database.php';

    use Service\Database;

    class Logement {

        public function __construct() {
            $this->db = new Database();
        }

        public function getAllReservation($id) {
            $reservations = $this->db->executeQuery("SELECT * FROM reservation");
            return $reservations;
        }

        public function getReservationByOwnerId($id) {
            $reservations = $this->db->executeQuery(`SELECT * FROM reservation WHERE id_reservation = $id`);
            return $reservations;
        }

        public function getHouseTitleByReservationId($id) {
            $houseTitle = $this->db->executeQuery(`SELECT titre FROM logement WHERE id_logement = $id`);
            return $houseTitle;
        }

        public function getClientUsernameByReservationId($id) {
            $clientUsername = $this->db->executeQuery(`SELECT pseudo FROM compte_client WHERE id_compte = $id`);
            return $clientUsername;
        }

        public function getReservationByOwnerIdWithState($id, $state) {
            $reservations = $this->db->executeQuery(`SELECT * FROM reservation WHERE id_reservation = $id`);
            return $clientUsername;
        }

        public function reservationExists($id) {
            $reservation = $this->db->executeQuery(`SELECT * FROM reservation WHERE id_reservation = $id`);
            return count($reservation) > 0;
        }
    }
?>