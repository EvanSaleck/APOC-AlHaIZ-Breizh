<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;

    class Logement {
        private $db;

        public function __construct() {
            $this->db = new Database();
            $this->db->executeQuery("SET SCHEMA 'sae3'");
        }

        public function getAllLogements() {
            $logements = $this->db->executeQuery('SELECT * FROM logement');
            
            return $logements;
        }
      
        public function getLogementById($id) {
            
            return json_encode($logements);
        }
      
        public function getLogementsDataForCards() {
            $dataLogements = $this->db->executeQuery('
            select l.id_logement,l.titre,l.description,l.image_principale,l.prix_nuit_ttc,ad.nom_ville,avg(av.note_avis) as moyenne_logement, count(av.id_avis) as nb_avis
                from logement l 
                    inner join adresse ad
                        on l.l_id_adresse  = ad.id_adresse 
                left join reservation r 
                    on l.id_logement = r.r_id_logement 
                left join avis av
                    on r.id_reservation = av.av_id_reservation 
                group by (l.id_logement,ad.id_adresse);
            ');
            
            return $dataLogements;
        }
      
        public function logementExists($id) {
            $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
            
            return count($logement) > 0;
        }

        public function getLogementById($id) {
            $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
            
            return json_encode($logement);
        }

        public function getLogementsDataForCards() {
            $dataLogements = $this->db->executeQuery('
            select l.id_logement,l.titre,l.description,l.image_principale,l.prix_nuit_ttc,ad.nom_ville,avg(av.note_avis) as moyenne_logement, count(av.id_avis) as nb_avis
                from logement l 
                    inner join adresse ad
                        on l.l_id_adresse  = ad.id_adresse 
                left join reservation r 
                    on l.id_logement = r.r_id_logement 
                left join avis av
                    on r.id_reservation = av.av_id_reservation 
                group by (l.id_logement,ad.id_adresse);
            ');
        
            return json_encode($dataLogements);
        }

        public function getLogementCompleteByID($id) {
            $logements = $this->db->executeQuery('
            SELECT * 
            FROM logement 
            JOIN adresse ON l_id_adresse = id_adresse
            
            WHERE id_logement = ' . $id);
            
            return json_encode($logements);
        }

        public function getAmenagementsOfLogementById($id) {
            $logements = $this->db->executeQuery('
            SELECT id_amenagement, nom_amenagement
            FROM logement
            JOIN amenagements_logement ON id_logement = al_id_logement
            JOIN amenagement ON al_id_amenagement = id_amenagement
            
            WHERE id_logement = ' . $id);
            
            return json_encode($logements);
        }
    }
?>
