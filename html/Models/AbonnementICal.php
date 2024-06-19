<?php

namespace Models;

include_once 'Service/Database.php';

use Service\Database;
use \Exception;

class AbonnementICal {

    private $db;

    private $dateDebut;
    private $dateFin;
    private $listeLogements;

    public function __construct($dateDebut = null, $dateFin = null, $listeLogements = null) {
        if ($dateDebut !== null) {
            $this->dateDebut = $dateDebut;
        }

        if ($dateFin !== null) {
            $this->dateFin = $dateFin;
        }

        if ($listeLogements !== null) {
            $this->listeLogements = $listeLogements;
        }

        $this->db = new Database();
    }

    public function newAbonnement() {

        try {
            $this->db->getPDO()->beginTransaction();
        
            $token = bin2hex(random_bytes(32));


            $query = "INSERT INTO abonnements_reservations(date_debut, date_fin, token, AR_id_compte) VALUES(:date_debut, :date_fin, :token, :AR_id_compte)";

            $this->db->executeQuery($query, array(
                ':date_debut' => $this->dateDebut,
                ':date_fin' => $this->dateFin,
                ':token' => $token,
                ':AR_id_compte' => $_SESSION['proprio']
            ));

            $idAbonnement = $this->db->getPDO()->lastInsertId();

            foreach($this->listeLogements as $logement) {
                $query = "INSERT INTO logement_abonnement(LA_id_logement, LA_id_abonnement) VALUES(:LA_id_logement, :LA_id_abonnement)";

                $this->db->executeQuery($query, array(
                    ':LA_id_logement' => $logement,
                    ':LA_id_abonnement' => $idAbonnement
                ));
            }

            $this->db->getPDO()->commit();

            return true;

        } catch (Exception $e) {
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de l\'enregistrement de l\'abonnement : ' . $e->getMessage());
        }
    }

    public function editAbonnement($id) {
        try {
            $this->db->getPDO()->beginTransaction();

            $query = "UPDATE abonnements_reservations SET date_debut = :date_debut, date_fin = :date_fin WHERE id_abonnement = :id_abonnement";

            $this->db->executeQuery($query, array(
                ':date_debut' => $this->dateDebut,
                ':date_fin' => $this->dateFin,
                ':id_abonnement' => $id
            ));

            $query = "DELETE FROM logement_abonnement WHERE LA_id_abonnement = :LA_id_abonnement";
            $this->db->executeQuery($query, array(':LA_id_abonnement' => $id));

            foreach($this->listeLogements as $logement) {
                $query = "INSERT INTO logement_abonnement(LA_id_logement, LA_id_abonnement) VALUES(:LA_id_logement, :LA_id_abonnement)";

                $this->db->executeQuery($query, array(
                    ':LA_id_logement' => $logement,
                    ':LA_id_abonnement' => $id
                ));
            }

            $this->db->getPDO()->commit();

            return true;

        } catch (Exception $e) {
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de la modification de l\'abonnement : ' . $e->getMessage());
        }
    }

    public function deleteAbonnement($id) {
        try {
            $this->db->getPDO()->beginTransaction();

            $query = "DELETE FROM logement_abonnement WHERE LA_id_abonnement = :LA_id_abonnement";
            $this->db->executeQuery($query, array(':LA_id_abonnement' => $id));

            $query = "DELETE FROM abonnements_reservations WHERE id_abonnement = :id_abonnement";
            $this->db->executeQuery($query, array(':id_abonnement' => $id));

            $this->db->getPDO()->commit();

            return true;

        } catch (Exception $e) {
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de la suppression de l\'abonnement : ' . $e->getMessage());
        }

        return 'test';
    }

    public function getAbonnementsByProprietaire($id) {
        $query = "SELECT * FROM abonnements_reservations WHERE AR_id_compte = :AR_id_compte ORDER BY date_creation DESC";

        $abonnements = $this->db->executeQuery($query,[':AR_id_compte' => $id]);

        return $abonnements;    
    }  
    
    public function getAbonnementByToken($token) {
        $query = "SELECT * FROM abonnements_reservations WHERE token = :token";

        $abonnement = $this->db->executeQuery($query,[':token' => $token]);

        return $abonnement;    
    }

    public function getAbonnementById($id) {
        $query = "
            SELECT abonnements_reservations.*, 
            STRING_AGG(LA_id_logement::varchar(50), ',') as logements 
            FROM abonnements_reservations 
            LEFT JOIN logement_abonnement ON id_abonnement = LA_id_abonnement 
            WHERE id_abonnement = :id_abonnement 
            GROUP BY id_abonnement
        ";

        $abonnement = $this->db->executeQuery($query,[':id_abonnement' => $id]);
        
        return $abonnement[0];
    }
}