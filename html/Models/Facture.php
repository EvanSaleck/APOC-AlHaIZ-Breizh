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
        /*
        public function getDataReservationById($id) {
            $reservations = $this->db->executeQuery("
            SELECT client.nom AS nomClient, 
                client.prenom AS prenomClient, 
                proprietaire.nom AS nomPro, 
                proprietaire.prenom AS prenomPro, 
                
                adresseFacturation.numero_rue AS numRueFact, 
                adresseFacturation.nom_rue AS nomRueFact, 
                adresseFacturation.complement AS compFact,
                adresseFacturation.code_postal AS codePostFact,
                adresseFacturation.nom_ville AS nomVilleFact,
                adresseFacturation.etat AS etatFact,
                adresseFacturation.pays AS paysFact,
                
                adresseProprietaire.numero_rue AS numRuePro, 
                adresseProprietaire.nom_rue AS nomRuePro, 
                adresseProprietaire.complement AS compPro,
                adresseProprietaire.code_postal AS codePostPro,
                adresseProprietaire.nom_ville AS nomVillePro,
                adresseProprietaire.etat AS etatPro,
                adresseProprietaire.pays AS paysPro,
                
                adresseLogement.numero_rue AS numRueLog, 
                adresseLogement.nom_rue AS nomRueLog, 
                adresseLogement.complement AS compLog,
                adresseLogement.code_postal AS codePostLog,
                adresseLogement.nom_ville AS nomVilleLog,
                
                reservation.date_arrivee,
                reservation.date_depart,
                reservation.nb_occupant,
                reservation.nb_nuit,
                reservation.frais_service,
                reservation.tarif_total AS tarif_total_resa,
                reservation.total_tarif_ttc AS tarif_sejour,
                reservation.taxe_sejour,
                
                logement.prix_nuit_ttc
                
            FROM reservation
            INNER JOIN logement ON R_id_logement = id_logement
            INNER JOIN compte_client AS client ON R_id_compte = client.id_compte
            INNER JOIN compte_proprietaire AS proprietaire ON L_id_compte = proprietaire.id_compte
            INNER JOIN adresse AS adresseFacturation ON client.CC_id_adresse = adresseFacturation.id_adresse
            INNER JOIN adresse AS adresseProprietaire ON proprietaire.C_id_adresse = adresseProprietaire.id_adresse
            INNER JOIN adresse AS adresseLogement ON logement.L_id_adresse = adresseLogement.id_adresse
            WHERE id_reservation = " . $id);
            return $reservations;
        }
        */
    }
?>