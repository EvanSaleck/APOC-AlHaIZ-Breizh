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

        public function getReservationsForExportICal($dateDeb, $dateFin, $listeLogements) {
            $placeholders = implode(',', array_fill(0, count($listeLogements), '?'));
        
            $query = "SELECT * FROM reservation WHERE date_arrivee >= ? AND date_depart <= ? AND R_id_logement IN ($placeholders)";
            
            $params = array_merge([$dateDeb, $dateFin], $listeLogements);
            
            $reservations = $this->db->executeQuery($query, $params);
        
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
            // Récupère les données nécessaires à l'affichage réduit de détails des réservation sur la page de liste des réservations Propriétaire
            $reservationsProprietaire = $this->db->executeQuery("SELECT id_reservation, l.titre, r.date_arrivee, r.date_depart, r.tarif_total, c.pseudo 
            FROM reservation AS r INNER JOIN logement AS l ON id_logement = R_id_logement INNER JOIN compte_client AS c ON id_compte = R_id_compte
            WHERE l.id_logement = r.r_id_logement AND l.l_id_compte = " . $id);

            return $reservationsProprietaire;
        }

        public function getReservationByClientId($id) {
            // Récupère les données nécessaires à l'affichage réduit de détails des réservation sur la page de liste des réservations Client
            $reservationsClient = $this->db->executeQuery("SELECT l.titre, r.date_arrivee, r.date_depart, r.tarif_total, p.pseudo FROM reservation AS r 
            INNER JOIN logement AS l ON id_logement = R_id_logement INNER JOIN compte_proprietaire AS p ON id_compte = l_id_compte
            WHERE l.id_logement = r.r_id_logement AND r.r_id_compte = " . $id);

            return $reservationsClient;
        }

        public function getOwnerById($id) {            
            $owner = $this->db->executeQuery("SELECT * FROM compte_proprietaire WHERE id_compte = " . $id);
            return $owner;
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

            $query = "INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, total_tarif_ttc, frais_service, taxe_sejour, tarif_total,  date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, FALSE, ?, ?)";
    
            $statement = $this->pdo->prepare($query);
    
            $dateReservation = date('Y-m-d');

            $statement->execute([
                $data['Nbnuits'],        // nb_nuit
                $data['dateArrivee'],    // date_arrivee
                $data['dateDepart'],     // date_depart
                $data['nbOccupants'],    // nb_occupant
                $data['totalTtc'],    // total_tarif_ttc
                $data['fraisService'],    // frais_service
                $data['taxeSejour'],    // taxe_sejour
                $data['tariftotalnuit'],    // tarif_total
                $dateReservation,        // date_reservation
                $data['id_logement'],    // R_id_logement
                $idcpt                   // R_id_compte
            ]);
                        
            $lastInsertId = $this->pdo->lastInsertId();

            return $lastInsertId;
        }
    }
?>