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
            header('Content-Type: application/json');
            echo $logements;
        }
            
        public function getLogementDataById($id) {
            $logements = $this->logement->getLogementCompleteByID($id);
            header('Content-Type: application/json');
            echo $logements;
        }

        public function getAmenagementsOfLogementById($id) {
            $logements = $this->logement->getAmenagementsOfLogementById($id);
            header('Content-Type: application/json');
            echo $logements;
        }
        
        public function getLogementsDataForCards() {
            $dataLogements = $this->logement->getLogementsDataForCards();
            header('Content-Type: application/json');
            echo $dataLogements;
        }

        public function logementExists($id) {
            return $this->logement->logementExists($id);
        }
    }
?>
