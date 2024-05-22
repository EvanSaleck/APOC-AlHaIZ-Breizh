<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;

    class Utilisateur {
        private $db;

        public function __construct() {
            $this->db = new Database();
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
    }