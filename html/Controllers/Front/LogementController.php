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
            $logements = $this->logement->getLogementCompleteByID($id);
            
            return $logements;
        }

        public function getAmenagementsOfLogementById($id) {
            $logements = $this->logement->getAmenagementsOfLogementById($id);
            
            return $logements;
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