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

    /**
     * Récupère les détails d'un compte client
     */
    public function getCompteClientDetails($idCompte) {
        $sql = "
            SELECT 
                c.id_compte, c.civilite, c.nom, c.prenom, c.e_mail, c.pseudo, c.photo_profil, c.ddn,
                cc.code_client, 
                a.numero_rue, a.nom_rue, a.code_postal, a.nom_ville, a.pays, a.complement, a.etat
            FROM sae3.compte_client cc
            INNER JOIN compte c ON cc.id_compte = c.id_compte
            INNER JOIN adresse a ON cc.c_id_adresse = a.id_adresse
            WHERE c.id_compte = " . $idCompte;
        $dataCompteClient = $this->db->executeQuery($sql);
    
        return $dataCompteClient;
    }

    /**
     * Récupère les détails d'un compte propriétaire
     */
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

    /**
     * connexionClient
     */
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
            return 'Identifiant et/ou mot de passe incorrects';
        }
    }

    /**
     * inscriptionClient
     */
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
    
    /**
     * connexion propietaire
     */
    public function connexionProprio($data) {
        // le champ peut être un pseudo ou un email
        // on vérifie si le champ contient un @ pour savoir si c'est un email
        // si c'est un email on fait la requête avec le champ e_mail
        // sinon on fait la requête avec le champ pseudo
        if(str_contains($data['pseudo'], '@')) {
            $query = "SELECT * FROM sae3.compte_proprietaire WHERE e_mail = ?";
        } else {
            $query = "SELECT * FROM sae3.compte_proprietaire WHERE pseudo = ?";
        }
        $statement = $this->pdo->prepare($query);
        $statement->execute([$data['pseudo']]);

        $utilisateur = $statement->fetch(\PDO::FETCH_ASSOC);

        // si l'utilisateur existe et que le mot de passe est correct on connecte l'utilisateur 
        if ($utilisateur && password_verify($data['password'], $utilisateur['mdp'])) {
            $_SESSION['proprio'] = json_encode($utilisateur);
            return 'Connexion réussie';
        } else {
            http_response_code(500);
            return 'Identifiants incorrects';
        }
    }

    /**
     * inscription propietaire
     */
    public function inscriptionProprio($data) {
        $query = "INSERT INTO sae3.compte_proprietaire (civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client) VALUES (?, ?, ?)";
        $statement = $this->pdo->prepare($query);

        // on hash le mot de passe à l'inscription
        $statement->execute([$data['pseudo'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);

        return 'Inscription réussie';
    }

    /**
     * Récupère un compte propriétaire par son id
     */
    public function getProprioById($id) {

        $query = "SELECT * FROM sae3.compte_proprietaire WHERE id_compte = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$id]);

        $proprio = $statement->fetch(\PDO::FETCH_ASSOC);

        return $proprio;
    }   

    /**
     *  on récupère les informations tous les tokens d'un propriétaire 
     */
    public function getAllTokenById($id){
        $query = "SELECT * FROM sae3.cle_api WHERE c_id_proprio = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$id]);

        $tokens = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $tokens;
    }

    /**
     * suppresion d'un token
     */
    public function deleteToken($cle, $idproprio){
        $query = "DELETE FROM sae3.cle_api WHERE cle = ? AND c_id_proprio = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$cle, $idproprio]);

        return 'Token supprime';
    }

    /**
     * génération d'un token
     */
    public function generateToken($id){
        $token = bin2hex(random_bytes(32));
        $query = "INSERT INTO sae3.cle_api (cle, c_id_proprio) VALUES (?, ?)";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$token, $id]);


        return 'Token genere';
    }

    /**
     * mise à jour d'un mot de passe
     */
    public function updatePassword($mdp, $newmdp, $confmdp, $id){
        $sql = "SELECT mdp FROM sae3.compte_proprietaire WHERE id_compte = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        // on vérifie si le mot de passe actuel est correct 
        if (!password_verify($mdp, $result['mdp'])) {
            return 'Mot de passe incorrect';
        }  
        if ($newmdp != $confmdp) {
            return 'Les mots de passe ne correspondent pas';
        }

        // on hash le nouveau mot de passe
        $newhash = password_hash($newmdp, PASSWORD_DEFAULT);
        $sql = "UPDATE sae3.compte_proprietaire SET mdp = ? WHERE id_compte = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$newhash, $id]);

        return 'Mot de passe modifie';
    }

    /**
     * mise à jour d'un mot de passe pour un client
     */
    public function updateCliPassword($mdp, $newmdp, $confmdp, $id){
        $sql = "SELECT mdp FROM sae3.compte_client WHERE id_compte = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        // on vérifie si le mot de passe actuel est correct
        if (!password_verify($mdp, $result['mdp'])) {
            return 'Mot de passe incorrect';
        }  
        if ($newmdp != $confmdp) {
            return 'Les mots de passe ne correspondent pas';
        }

        // on hash le nouveau mot de passe
        $newhash = password_hash($newmdp, PASSWORD_DEFAULT);
        $sql = "UPDATE sae3.compte_client SET mdp = ? WHERE id_compte = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$newhash, $id]);

        return 'Mot de passe modifie';
    }

    /**
     * mise à jour d'un profil
     */
    public function updateProfile($values){
        $sql = "UPDATE sae3.compte_proprietaire 
                SET civilite = ?, nom = ?, prenom = ?, e_mail = ?, pseudo = ?, ddn = ? 
                WHERE id_compte = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $values['civilite'], 
            $values['nom'], 
            $values['prenom'], 
            $values['email'], 
            $values['pseudo'], 
            $values['ddn'], 
            $values['id']
        ]);
    
        $sqladresse = "SELECT c_id_adresse FROM sae3.compte_proprietaire WHERE id_compte = ?";
        $stmtadresse = $this->pdo->prepare($sqladresse);
        $stmtadresse->execute([$values['id']]);
        $adr = $stmtadresse->fetch(\PDO::FETCH_ASSOC);
    
        // Vérifier si l'adresse a été trouvée
        if ($adr) {
            // Extraction du numéro de rue et du nom de rue
            $rueParts = explode(' ', $values['rue'], 2);
            $numero_rue = $rueParts[0];
            $nom_rue = isset($rueParts[1]) ? $rueParts[1] : '';
    
            // Requête UPDATE pour adresse
            $sql2 = "UPDATE sae3.adresse 
                     SET numero_rue = ?, nom_rue = ?, code_postal = ?, nom_ville = ?, pays = ? 
                     WHERE id_adresse = ?";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute([
                $numero_rue, 
                $nom_rue, 
                $values['codePostal'], 
                $values['ville'], 
                $values['pays'], 
                $adr['c_id_adresse']
            ]);
        }
    
        return 'Profil modifie';
    }

    // mise à jour d'un profil pour un client
    public function updateCliProfile($values){
        $sql = "UPDATE sae3.compte_client
                SET civilite = ?, nom = ?, prenom = ?, e_mail = ?, pseudo = ?
                WHERE id_compte = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $values['civilite'], 
            $values['nom'], 
            $values['prenom'], 
            $values['email'], 
            $values['pseudo'], 
            $values['id']
        ]);
    
        // Requête pour récupérer l'identifiant de l'adresse
        $sqladresse = "SELECT c_id_adresse FROM sae3.compte_client WHERE id_compte = ?";
        $stmtadresse = $this->pdo->prepare($sqladresse);
        $stmtadresse->execute([$values['id']]);
        $adr = $stmtadresse->fetch(\PDO::FETCH_ASSOC);
    
        // Vérifier si l'adresse a été trouvée
        if ($adr) {
            // Extraction du numéro de rue et du nom de rue
            $rueParts = explode(' ', $values['rue'], 2);
            $numero_rue = $rueParts[0];
            $nom_rue = isset($rueParts[1]) ? $rueParts[1] : '';
    
            // Requête UPDATE pour adresse
            $sql2 = "UPDATE sae3.adresse 
                     SET numero_rue = ?, nom_rue = ?, code_postal = ?, nom_ville = ?, pays = ? 
                     WHERE id_adresse = ?";
            $stmt2 = $this->pdo->prepare($sql2);
            $stmt2->execute([
                $numero_rue, 
                $nom_rue, 
                $values['codePostal'], 
                $values['ville'], 
                $values['pays'], 
                $adr['c_id_adresse']
            ]);
        }
    
        return 'Profil modifie';
    }
}