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

        /**
         * Récupère les factures d'un compte client
         */
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

        /**
         * Récupère les factures d'un compte client
         */
        public function isAllowed($idFacture,$idCompte) {
            $facture = $this->db->executeQuery("
                SELECT id_facture
                FROM facture
                INNER JOIN reservation ON id_reservation = f_id_reservation
                INNER JOIN logement AS l ON l.id_logement = reservation.r_id_logement
                WHERE id_facture = ".$idFacture." AND (r_id_compte = ".$idCompte." OR l_id_compte = ".$idCompte.")"
            );

            return !empty($facture);
        }

        /**
         * Création d'une facture
         */
        public function createFacture() {
            $facture = $this->db->executeQuery("
            INSERT INTO facture (date_facture,nom_logement,prix_nuit_ht,numero_rue_pro,nom_rue_pro,code_postal_pro,nom_ville_pro,pays_pro,complement_pro,etat_pro,numero_rue_client,nom_rue_client,code_postal_client,nom_ville_client,pays_client,complement_client,etat_client,nom_proprietaire,prenom_proprietaire,email_proprietaire,nom_client,prenom_client,email_client,f_id_reservation) 
            SELECT NOW() AS date_facture,
                
                logement.titre AS nom_logement,
                logement.prix_nuit_ht AS prix_nuit_ht,
                
                adresseProprietaire.numero_rue AS numero_rue_pro, 
                adresseProprietaire.nom_rue AS nom_rue_pro, 
                adresseProprietaire.code_postal AS code_postal_pro,
                adresseProprietaire.nom_ville AS nom_ville_pro,
                adresseProprietaire.pays AS pays_pro,
                adresseProprietaire.etat AS etat_pro,
                adresseProprietaire.complement AS complement_pro,
                                    
                adresseFacturation.numero_rue AS numero_rue_client, 
                adresseFacturation.nom_rue AS nom_rue_client, 
                adresseFacturation.code_postal AS code_postal_client,
                adresseFacturation.nom_ville AS nom_ville_client,
                adresseFacturation.pays AS pays_client,
                adresseFacturation.etat AS etat_client,
                adresseFacturation.complement AS complement_client,
                
                proprietaire.nom AS nom_proprietaire, 
                proprietaire.prenom AS prenom_proprietaire, 
                proprietaire.e_mail AS email_proprietaire,
                
                client.nom AS nom_client, 
                client.prenom AS prenom_client, 
                client.e_mail AS email_client,
                
                id_reservation
                                
            FROM reservation
            INNER JOIN logement ON id_logement = R_id_logement
            INNER JOIN compte_client AS client ON R_id_compte = client.id_compte
            INNER JOIN compte_proprietaire AS proprietaire ON L_id_compte = proprietaire.id_compte
            INNER JOIN adresse AS adresseFacturation ON client.C_id_adresse = adresseFacturation.id_adresse
            INNER JOIN adresse AS adresseProprietaire ON proprietaire.C_id_adresse = adresseProprietaire.id_adresse
            WHERE id_reservation = (SELECT MAX(id_reservation) FROM reservation)");
        }
    }
?>