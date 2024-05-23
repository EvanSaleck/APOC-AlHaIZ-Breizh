<?php
namespace Models;

include_once 'Service/Database.php';

use Service\Database;

class Utilisateur {

    public function connexionClient($data) {
        $db = new Database();
        $pdo = $db->getPDO();

        if(str_contains($data['pseudo'], '@')) {
            $query = "SELECT * FROM sae3.compte_client WHERE e_mail = ?";
        } else {
            $query = "SELECT * FROM sae3.compte_client WHERE pseudo = ?";
        }
        $statement = $pdo->prepare($query);
        $statement->execute([$data['pseudo']]);

        $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($data['password'], $utilisateur['mdp'])) {
            session_start();
            $_SESSION['client'] = json_encode($utilisateur);
            return 'Connexion réussie';
        } else {
            http_response_code(500);
            return 'Identifiants incorrects';
        }
    }

    public function inscriptionClient($data) {
        $db = new Database();
        $pdo = $db->getPDO();

        $query = "INSERT INTO sae3.compte_client (civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$data['pseudo'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);

        return 'Inscription réussie';
    }

    public function connexionProprio($data) {
        $db = new Database();
        $pdo = $db->getPDO();

        if(str_contains($data['pseudo'], '@')) {
            $query = "SELECT * FROM sae3.compte_proprietaire WHERE e_mail = ?";
        } else {
            $query = "SELECT * FROM sae3.compte_proprietaire WHERE pseudo = ?";
        }
        $statement = $pdo->prepare($query);
        $statement->execute([$data['pseudo']]);

        $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($data['password'], $utilisateur['mdp'])) {
            session_start();
            $_SESSION['proprio'] = json_encode($utilisateur);
            return 'Connexion réussie';
        } else {
            http_response_code(500);
            return 'Identifiants incorrects';
        }
    }

    public function inscriptionProprio($data) {
        $db = new Database();
        $pdo = $db->getPDO();

        $query = "INSERT INTO sae3.compte_proprietaire (civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$data['pseudo'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);

        return 'Inscription réussie';
    }

    public function getProprioById($id) {
        $db = new Database();
        $pdo = $db->getPDO();

        $query = "SELECT * FROM sae3.compte_proprietaire WHERE id_compte = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);

        $proprio = $statement->fetch(\PDO::FETCH_ASSOC);

        return $proprio;
    }   
}
