<?php
namespace Models;

include_once 'Service/Database.php';

use Service\Database;

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
        if (strpos($data['pseudo'], '@') !== false) {
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
    

    public function inscriptionClient($data) {
        $query = "INSERT INTO sae3.compte_client (civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client) VALUES (?, ?, ?)";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$data['pseudo'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);

        return 'Inscription réussie';
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
