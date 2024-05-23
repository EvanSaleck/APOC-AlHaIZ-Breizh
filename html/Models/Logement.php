<?php
    namespace Models;

    include_once 'Service/Database.php';

    use Service\Database;

    class Logement {
        private $db;


        public function __construct() {
            $this->db = new Database();
        }

        public function GetIdReservation() {
            $logements = $this->db->executeQuery('SELECT * FROM logement');
            
            return $logements;
        }
      
        public function getLogementById($id) {
            
            $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
                
            return $logement;
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
    }
?>
    
