<?php
namespace Models;

include_once 'Service/Database.php';

use Service\Database;
use \Exception;

class Utilisateur {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->getPDO(); 
    }

    public function getCompteClientDetails($idCompte) {
        $sql = "
            SELECT 
                c.id_compte, c.civilite, c.nom, c.prenom, c.e_mail, c.pseudo, c.photo_profil, c.ddn,
                cc.code_client, 
                a.numero_rue, a.nom_rue, a.code_postal, a.nom_ville, a.pays, a.complement, a.etat
            FROM sae3.compte_client cc
            INNER JOIN compte c ON cc.id_compte = c.id_compte
            INNER JOIN adresse a ON cc.cc_id_adresse = a.id_adresse
            WHERE c.id_compte = " . $idCompte;
        $dataCompteClient = $this->db->executeQuery($sql);
    
        return $dataCompteClient;
    }

    public function connexionClient($data) {
        if(str_contains($data['pseudo'], '@')) {
            $query = "SELECT * FROM sae3.compte_client WHERE e_mail = ?";
        } else {
            $query = "SELECT * FROM sae3.compte_client WHERE pseudo = ?";
        }
        $statement = $this->pdo->prepare($query);
        $statement->execute([$data['pseudo']]);

        $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($data['password'], $utilisateur['mdp'])) {
            $_SESSION['client'] = json_encode($utilisateur);
            return 'Connexion réussie';
        } else {
            http_response_code(500);
            return 'Identifiants incorrects';
        }
    }

    // public function inscriptionClient($data) {
    //     $query = "INSERT INTO sae3.compte_client (civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client) VALUES (?, ?, ?)";
    //     $statement = $this->pdo->prepare($query);
    //     $statement->execute([$data['pseudo'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);

    //     return 'Inscription réussie';
    // }
    
    public function inscriptionClient($data) {
        try {
            $this->db->getPDO()->beginTransaction();

            // Insertion de l'adresse
            $colonnesAdresse = ['numero_rue', 'nom_rue', 'code_postal', 'nom_ville', 'pays', 'complement', 'etat'];
            $valeursAdresse = [
                $data['numero_rue'],
                $data['nom_rue'],
                $data['code_postal'],
                $data['nom_ville'],
                $data['pays'],
                $data['complement'] ?? null,
                $data['etat'] ?? null
            ];
            $this->db->insert('adresse', $colonnesAdresse, $valeursAdresse);
            $idAdresse = $this->db->getPDO()->lastInsertId();

            // Insertion du compte
            $colonnesCompte = ['civilite', 'nom', 'prenom', 'e_mail', 'mdp', 'pseudo', 'photo_profil', 'ddn', 'C_id_adresse'];
            $valeursCompte = [
                $data['civilite'],
                $data['nom'],
                $data['prenom'],
                $data['email'],
                $data['motDePasse'], // Assurez-vous que le mot de passe soit hashé avant insertion
                $data['nomUtilisateur'],
                $data['photoProfil'],
                $data['dateNaissance'],
                $idAdresse
            ];
            $this->db->insert('compte', $colonnesCompte, $valeursCompte);
            $idCompte = $this->db->getPDO()->lastInsertId();

            // Génération du code client
            $codeClient = strtoupper(substr($data['prenom'], 0, 3) . $data['nom'] . $idCompte);

            // Insertion du compte client
            $colonnesCompteClient = ['id_compte', 'code_client', 'CC_id_adresse'];
            $valeursCompteClient = [
                $idCompte,
                $codeClient,
                $idAdresse
            ];
            $this->db->insert('compte_client', $colonnesCompteClient, $valeursCompteClient);

            $this->db->getPDO()->commit();
            return true;
        } catch (Exception $e) {
            $this->db->getPDO()->rollBack();
            error_log('Erreur lors de l\'inscription : ' . $e->getMessage());
            return false;
        }
    }
    
    
    


    public function connexionProprio($data) {
        if(str_contains($data['pseudo'], '@')) {
            $query = "SELECT * FROM sae3.compte_proprietaire WHERE e_mail = ?";
        } else {
            $query = "SELECT * FROM sae3.compte_proprietaire WHERE pseudo = ?";
        }
        $statement = $this->pdo->prepare($query);
        $statement->execute([$data['pseudo']]);

        $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($data['password'], $utilisateur['mdp'])) {
            $_SESSION['proprio'] = json_encode($utilisateur);
            return 'Connexion réussie';
        } else {
            http_response_code(500);
            return 'Identifiants incorrects';
        }
    }

    public function inscriptionProprio($data) {
        $query = "INSERT INTO sae3.compte_proprietaire (civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client) VALUES (?, ?, ?)";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$data['pseudo'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);

        return 'Inscription réussie';
    }

    public function getProprioById($id) {

        $query = "SELECT * FROM sae3.compte_proprietaire WHERE id_compte = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$id]);

        $proprio = $statement->fetch(\PDO::FETCH_ASSOC);

        return $proprio;
    }   
}
