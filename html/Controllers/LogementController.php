<?php
    namespace Controllers;
    
    include_once 'Models/Logement.php';
    include_once 'Service/FormNewLogement.php';
    
    use Models\Logement;
    use Service\FormNewLogement;

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

        public function processFormNewLogement() { 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
                $tabNomRue = explode(' ', $_POST['nom_rue']);
                $numeroRue = $tabNomRue[0];
                $nomRue = '';
                for ($i = 1; $i < count($tabNomRue); $i++) {
                    $nomRue .= $tabNomRue[$i] . ' ';
                } 
    
                $photo = null;
    
                $formLogement = new FormNewLogement(
                    $_POST['titre'],
                    $_POST['tarif'],
                    $nomRue,
                    $_POST['ville'],
                    $_POST['cp'],
                    $_POST['pays'],
                    $photo,
                    $_POST['amenagements'],
                    $_POST['surface'],
                    $_POST['nbPersMax'],
                    $_POST['nbChambres'],
                    $_POST['nbLitsSimples'],
                    $_POST['nbLitsDoubles'],
                    $_POST['type'],
                    $_POST['categorie']
                );
    
                $formLogement->setNotRequiredFields(
                    $numeroRue,
                    (isset($_POST['complement_adresse']) ? $_POST['complement_adresse'] : ''),
                    (isset($_POST['etat']) ? $_POST['etat'] : ''),
                    (isset($_POST['accroche']) ? $_POST['accroche'] : ''),
                    (isset($_POST['description']) ? $_POST['description'] : ''),
                    (isset($_POST['delaiResaArrivee']) ? $_POST['delaiResaArrivee'] : ''),
                    (isset($_POST['dureeMinLoc']) ? $_POST['dureeMinLoc'] : ''),
                    (isset($_POST['delaiAnnulMax']) ? $_POST['delaiAnnulMax'] : '')
                );     
                
                header('Content-Type: application/json');
    
                try {
                    $formLogement->insert();
                    echo json_encode('true');
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'uniquement accessible avec la methode POST']);
            }
        } 
    }
?>