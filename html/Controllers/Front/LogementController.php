<?php
    namespace Controllers\Front;
    
    include_once 'Models/Logement.php';
    
    use Models\Logement;

    class LogementController {

        private $logement;

        public function __construct() {
            $this->logement = new Logement();
        }

        public function getAllLogements() {            
            $logements = $this->logement->getAllLogements();
                
            return $logements;
        }
            
        public function getLogementDataById($id) {
            $logement = $this->logement->getLogementById($id);
                
            return $logement;
        }
        
        public function getLogementsDataForCards() {
            $dataLogements = $this->logement->getLogementsDataForCards();

            return $dataLogements;
        }

        public function logementExists($id) {
            return $this->logement->logementExists($id);
        }
    }
?>