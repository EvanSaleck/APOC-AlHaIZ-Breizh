<?php

namespace Models;

include_once 'Service/Database.php';

use Service\Database;
use \Exception;

class AbonnementICal {

    private $db;

    private $titre;
    private $dateDebut;
    private $dateFin;
    private $listeLogements;

    public function __construct($titre = null, $dateDebut = null, $dateFin = null, $listeLogements = null) {
        if ($titre !== null) {
            $this->titre = $titre;
        }

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

    /**
     * Création d'un nouvel abonnement
     */
    public function newAbonnement($id) {

        try {
            // on démarre une transaction
            $this->db->getPDO()->beginTransaction();
        
            $token = bin2hex(random_bytes(32));

            // on initialise la requete
            $query = "INSERT INTO abonnements_reservations(titre, date_debut, date_fin, token, AR_id_compte) VALUES(:titre,:date_debut, :date_fin, :token, :AR_id_compte)";

            // on execute la requete en passant les parametres
            $this->db->executeQuery($query, array(
                ':titre' => $this->titre,
                ':date_debut' => $this->dateDebut,
                ':date_fin' => $this->dateFin,
                ':token' => $token,
                ':AR_id_compte' => $id
            ));

            // on récupère l'id de l'abonnement (dernier insert)
            $idAbonnement = $this->db->getPDO()->lastInsertId();

            // on boucle sur la liste des logements
            foreach($this->listeLogements as $logement) {
                $query = "INSERT INTO logement_abonnement(LA_id_logement, LA_id_abonnement) VALUES(:LA_id_logement, :LA_id_abonnement)";

                $this->db->executeQuery($query, array(
                    ':LA_id_logement' => $logement,
                    ':LA_id_abonnement' => $idAbonnement
                ));
            }

            // si tout s'est bien passé, on valide la transaction
            $this->db->getPDO()->commit();

            return true;

        } catch (Exception $e) {
            // si une erreur survient, on annule la transaction et on déclenche une exception
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de l\'enregistrement de l\'abonnement : ' . $e->getMessage());
        }
    }

    /**
     * Modification d'un abonnement
     */
    public function editAbonnement($id) {
        try {
            // on démarre une transaction
            $this->db->getPDO()->beginTransaction();

            // on initialise la requete
            $query = "UPDATE abonnements_reservations SET titre = :titre, date_debut = :date_debut, date_fin = :date_fin, nb_modifications = nb_modifications + 1 WHERE id_abonnement = :id_abonnement";

            // on execute la requete en passant les parametres
            $this->db->executeQuery($query, array(
                ':titre' => $this->titre,
                ':date_debut' => $this->dateDebut,
                ':date_fin' => $this->dateFin,
                ':id_abonnement' => $id
            ));

            // on supprime les logements associés à l'abonnement pour tout réinsérer après sans avoir a faire de vérification
            $query = "DELETE FROM logement_abonnement WHERE LA_id_abonnement = :LA_id_abonnement";
            $this->db->executeQuery($query, array(':LA_id_abonnement' => $id));

            // on boucle sur la liste des logements 
            foreach($this->listeLogements as $logement) {
                $query = "INSERT INTO logement_abonnement(LA_id_logement, LA_id_abonnement) VALUES(:LA_id_logement, :LA_id_abonnement)";

                $this->db->executeQuery($query, array(
                    ':LA_id_logement' => $logement,
                    ':LA_id_abonnement' => $id
                ));
            }

            // si tout s'est bien passé, on valide la transaction
            $this->db->getPDO()->commit();

            return true;

        } catch (Exception $e) {
            // si une erreur survient, on annule la transaction et on déclenche une exception
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de la modification de l\'abonnement : ' . $e->getMessage());
        }
    }

    // Suppression d'un abonnement
    public function deleteAbonnement($id) {
        try {
            // on démarre une transaction
            $this->db->getPDO()->beginTransaction();

            // on récupère le token
            $query = "SELECT token FROM abonnements_reservations WHERE id_abonnement = :id_abonnement";
            $token = $this->db->executeQuery($query, array(':id_abonnement' => $id))[0]['token'];

            // on supprime les lignes de la table de liaison
            $query = "DELETE FROM logement_abonnement WHERE LA_id_abonnement = :LA_id_abonnement";
            $this->db->executeQuery($query, array(':LA_id_abonnement' => $id));

            // on supprime l'abonnement
            $query = "DELETE FROM abonnements_reservations WHERE id_abonnement = :id_abonnement";
            $this->db->executeQuery($query, array(':id_abonnement' => $id));

            // si tout s'est bien passé, on valide la transaction
            $this->db->getPDO()->commit();

            // on supprime le fichier ical associé si il existe
            if(file_exists("icalfiles/$token.ics")) {
                unlink("icalfiles/$token.ics");
            }

            return true;

        } catch (Exception $e) {
            // si une erreur survient, on annule la transaction et on déclenche une exception
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de la suppression de l\'abonnement : ' . $e->getMessage());
        }
    }

    /**
     * Récupère tous les abonnements d'un propriétaire
     */
    public function getAbonnementsByProprietaire($id) {
        $query = "SELECT * FROM abonnements_reservations WHERE AR_id_compte = :AR_id_compte ORDER BY date_creation DESC";

        $abonnements = $this->db->executeQuery($query,[':AR_id_compte' => $id]);

        return $abonnements;    
    }  
    
    /**
     * Récupère un abonnement par son token
     */
    public function getAbonnementByToken($token) {
        $query = "SELECT * FROM abonnements_reservations WHERE token = :token";

        $abonnement = $this->db->executeQuery($query,[':token' => $token]);

        return $abonnement;    
    }

    /**
     * Récupère un abonnement par son id
     */
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