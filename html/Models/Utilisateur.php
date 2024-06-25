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

    public function getCompteProprietaireDetails($idCompte) {
        $sql = "
            SELECT 
                p.id_compte, p.civilite, p.nom, p.prenom, p.e_mail, p.pseudo, p.photo_profil, p.ddn, cp.date_cni_fin_valid,
                a.numero_rue, a.nom_rue, a.code_postal, a.nom_ville, a.pays, a.complement, a.etat 
            FROM sae3.compte_proprietaire cp
            INNER JOIN compte p ON cp.id_compte = p.id_compte
            INNER JOIN adresse a ON cp.c_id_adresse = a.id_adresse
            WHERE p.id_compte = " . $idCompte;
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

    
    public function inscriptionClient($data) {
        try {
            $this->db->getPDO()->beginTransaction();
            // on commence par regarder si un utilisateur n'existe pas deja avec le meme email

            $query = "SELECT * FROM sae3.compte_client WHERE e_mail = ?";
            $statement = $this->pdo->prepare($query);
            $statement->execute([$data['email']]);
            $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($utilisateur) {
                throw new Exception('Un utilisateur existe déjà avec cet email');
            }

            // ensuite si un utilisateur n'existe pas deja avec le meme pseudo
            $query = "SELECT * FROM sae3.compte_client WHERE pseudo = ?";
            $statement = $this->pdo->prepare($query);
            $statement->execute([$data['pseudo']]);
            $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($utilisateur) {
                throw new Exception('Un utilisateur existe déjà avec ce pseudo');
            }

            $query = "INSERT INTO sae3.adresse (numero_rue, nom_rue, code_postal, nom_ville, pays, complement, etat) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                $data['numero_rue'],
                $data['nom_rue'],
                $data['code_postal'],
                $data['nom_ville'],
                $data['pays'],
                $data['complement'],
                $data['etat']
            ]);
            

            $idAdresse = $this->db->getPDO()->lastInsertId();

            
            // puis creation compte a laquelle rajouter l'id de l'adresse
            $query = "INSERT INTO sae3.compte_client (code_client, civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, C_id_adresse, CC_id_adresse) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $statement = $this->pdo->prepare($query);
            $date = date('Y-m-d', strtotime($data['ddn']));

            $codeClient = strtoupper(substr($data['prenom'], 0, 3) . $data['nom']);

            $statement->execute([
                $codeClient,
                $data['civilite'],
                $data['nom'],
                $data['prenom'],
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['pseudo'],
                $data['photo_profil'],
                $date,
                $idAdresse,
                $idAdresse,
            ]);

            $idCompte = $this->db->getPDO()->lastInsertId();

            // puis on update le compte client pour ajouter l'id du compte a la suite du code client

            $query = "UPDATE sae3.compte_client SET code_client = ? WHERE id_compte = ?";
            $statement = $this->pdo->prepare($query);
            $codeClient = strtoupper(substr($data['prenom'], 0, 3) . $data['nom'] . $idCompte );
            $statement->execute([$codeClient, $idCompte]);
            
            $this->db->getPDO()->commit();

            $query = "SELECT * FROM sae3.compte_client WHERE code_client = ?";
            $statement = $this->pdo->prepare($query);
            $statement->execute([$codeClient]);
            $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);
            
            return 'Inscription réussie';
        } catch (Exception $e) {
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de l\'inscription : ' . $e->getMessage());
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

    public function getAllTokenById($id){
        $query = "SELECT * FROM sae3.cle_api WHERE c_id_proprio = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$id]);

        $tokens = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $tokens;
    }

    public function deleteToken($cle, $idproprio){
        $query = "DELETE FROM sae3.cle_api WHERE cle = ? AND c_id_proprio = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$cle, $idproprio]);

        return 'Token supprime';
    }

    public function generateToken($id){
        $token = bin2hex(random_bytes(32));
        $query = "INSERT INTO sae3.cle_api (cle, c_id_proprio) VALUES (?, ?)";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$token, $id]);


        return 'Token genere';
    }

}


