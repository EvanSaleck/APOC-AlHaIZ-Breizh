<?php

namespace Controllers;

include_once 'Models/Logement.php';
include_once 'Service/FormNewLogement.php';

use Models\Logement;
use Service\FormNewLogement;
use Exception;

class LogementController {
    private $logement;

    public function __construct() {
        $this->logement = new Logement();
    }
        
    /**
     * Récupérer tous les logements
     */
    public function getAllLogements() {            
        $logements = $this->logement->getAllLogements();
            
        header('Content-Type: application/json');
            
        echo json_encode($logements);
    }

    /**
     * Récupérer les logements d'un propriétaire
     */
    public function getLogementsByProprietaireId($id) {
        $logements = $this->logement->getLogementsByProprietaireId($id);

        header('Content-Type: application/json');

        echo json_encode($logements);
    }
        

    /**
     * Récupérer un logement par son ID
     */
    public function getLogementById($id) {
            
        $logement = $this->logement->getLogementById($id);
                    
        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }  
    
    /**
     * Mettre à jour le statut d'un logement
     */
    public function updateStatus($id, $status){
        $logement = $this->logement->updateStatutLogement($id, $status);

        header('Content-Type: application/json');
            
        echo json_encode($logement);
    }

    /**
     * Récupérer les données des logements pour les cartes sur la page d'accueil
     */
    public function getLogementsDataForCards() {
        $dataLogements = $this->logement->getLogementsDataForCards();

        header('Content-Type: application/json');

        echo json_encode($dataLogements);
    }

    /**
     * Récupérer les données d'un logement par son ID
     */
    public function getLogementDataById($id) {
        $logement = $this->logement->getLogementCompleteByID($id);

        header('Content-Type: application/json');

        echo json_encode($logement);
    }

    /**
     * Récupérer les aménagements d'un logement par son ID
     */
    public function getAmenagementsOfLogementById($id) {
        $amenagements = $this->logement->getAmenagementsOfLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($amenagements);
    }

    /**
     * Récupérer le type d'un logement par son ID
     */
    public function getTypeOfLogementById($id) {
        $logements = $this->logement->getTypeOfLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($logements);
    }

    /**
     * Récupérer les logements disponibles pour une période donnée
     */
    public function getLogementsDispo($startDate = null, $endDate = null) {
        header('Content-Type: application/json');
        
        // si les dates de début et de fin ne sont pas fournies, on renvoie une erreur
        if ($startDate === null || $endDate === null) {
            echo json_encode(['error' => 'Dates de début et de fin non fournies.']);
            return;
        }

        $logements = $this->logement->getLogementsDispo($startDate, $endDate);


        echo json_encode($logements);
    }

    /**
     * Vérifier si un logement est disponible pour une période donnée
     */
    public function isDisponible($id, $startDate = null, $endDate = null) {
        header('Content-Type: application/json');
        
        // si les dates de début et de fin ne sont pas fournies, on renvoie une erreur
        if ($startDate === null || $endDate === null) {
            echo json_encode(['error' => 'Dates de début et de fin non fournies.']);
            return;
        }

        $dispo = $this->logement->isDisponible($id, $startDate, $endDate);

        echo json_encode($dispo);
    }

    /**
     * Récupérer la catégorie d'un logement par son ID
     */
    public function getCategorieOfLogementById($id) {
        $logements = $this->logement->getCategorieOfLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($logements);
    }

    /**
     * Récupérer les logements d'une ville
     */
    public function processFormNewLogement() { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // on récupère le numéro de rue et le nom de la rue séparément
            $tabNomRue = explode(' ', htmlentities($_POST['nom_rue']));
            if(is_numeric($tabNomRue[0])) {
                $numeroRue = $tabNomRue[0];
                $nomRue = '';
                for ($i = 1; $i < count($tabNomRue); $i++) {
                    $nomRue .= $tabNomRue[$i] . ' ';
                } 
            } else {
                $numeroRue = null;
                $nomRue = htmlentities($_POST['nom_rue']);
            }

            $photo = null;

            // on initialise l'objet FormNewLogement avec les données du formulaire
            $formLogement = new FormNewLogement(
                htmlentities($_POST['titre']),
                htmlentities($_POST['tarif']),
                $nomRue,
                htmlentities($_POST['ville']),
                htmlentities($_POST['cp']),
                $photo,
                htmlentities($_POST['amenagements']),
                htmlentities($_POST['surface']),
                htmlentities($_POST['nbPersMax']),
                htmlentities($_POST['nbChambres']),
                htmlentities($_POST['nbLitsSimples']),
                htmlentities($_POST['nbLitsDoubles']),
                htmlentities($_POST['type']),
                htmlentities($_POST['categorie']),
                htmlentities($_POST['pays']),
                htmlentities($_POST['etat'])
            );

            // on définit les champs facultatifs
            $formLogement->setNotRequiredFields(
                $numeroRue,
                (isset($_POST['complement_adresse']) ? htmlentities($_POST['complement_adresse']) : ''),
                (isset($_POST['accroche']) ? htmlentities($_POST['accroche']) : ''),
                (isset($_POST['description']) ? htmlentities($_POST['description']) : ''),
                (isset($_POST['delaiResaArrivee']) ? htmlentities($_POST['delaiResaArrivee']) : ''),
                (isset($_POST['dureeMinLoc']) ? htmlentities($_POST['dureeMinLoc']) : ''),
                (isset($_POST['delaiAnnulMax']) ? htmlentities($_POST['delaiAnnulMax']) : '')
            );     
            
            header('Content-Type: application/json');

            // on insère le logement dans la base de données avec la méhotde insert du service FormNewLogement
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
    
    public function processFormUpdateLogement() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Récupération de l'ID du logement à mettre à jour
        $idLogement = isset($_POST['id_logement']) ? intval($_POST['id_logement']) : null;
        if ($idLogement === null) {
            echo json_encode(['error' => 'ID du logement non fourni.']);
            return;
        }

        // Décodage des données encodées
        $titre = isset($_POST['titre']) ? urldecode($_POST['titre']) : '';
        $tarif = isset($_POST['tarif']) ? urldecode($_POST['tarif']) : '';
        $nomRue = isset($_POST['nom_rue']) ? urldecode($_POST['nom_rue']) : '';
        $ville = isset($_POST['ville']) ? urldecode($_POST['ville']) : '';
        $cp = isset($_POST['cp']) ? urldecode($_POST['cp']) : '';
        $amenagements = isset($_POST['amenagements']) ? urldecode($_POST['amenagements']) : '';
        $surface = isset($_POST['surface']) ? urldecode($_POST['surface']) : '';
        $nbPersMax = isset($_POST['nbPersMax']) ? urldecode($_POST['nbPersMax']) : '';
        $nbChambres = isset($_POST['nbChambres']) ? urldecode($_POST['nbChambres']) : '';
        $nbLitsSimples = isset($_POST['nbLitsSimples']) ? urldecode($_POST['nbLitsSimples']) : '';
        $nbLitsDoubles = isset($_POST['nbLitsDoubles']) ? urldecode($_POST['nbLitsDoubles']) : '';
        $type = isset($_POST['type']) ? urldecode($_POST['type']) : '';
        $categorie = isset($_POST['categorie']) ? urldecode($_POST['categorie']) : '';
        $pays = isset($_POST['pays']) ? urldecode($_POST['pays']) : '';
        $etat = isset($_POST['etat']) ? urldecode($_POST['etat']) : '';

        // D'autres champs facultatifs
        $numeroRue = isset($_POST['numero_rue']) ? urldecode($_POST['numero_rue']) : '';
        $complementAdresse = isset($_POST['complement_adresse']) ? urldecode($_POST['complement_adresse']) : '';
        $accroche = isset($_POST['accroche']) ? urldecode($_POST['accroche']) : '';
        $description = isset($_POST['description']) ? urldecode($_POST['description']) : '';
        $delaiResaArrivee = isset($_POST['delaiResaArrivee']) ? urldecode($_POST['delaiResaArrivee']) : '';
        $dureeMinLoc = isset($_POST['dureeMinLoc']) ? urldecode($_POST['dureeMinLoc']) : '';
        $delaiAnnulMax = isset($_POST['delaiAnnulMax']) ? urldecode($_POST['delaiAnnulMax']) : '';

        // Création de l'objet FormNewLogement avec les données décodées
        $formLogement = new FormNewLogement(
            $titre,
            $tarif,
            $nomRue,
            $ville,
            $cp,
            null,
            $amenagements,
            $surface,
            $nbPersMax,
            $nbChambres,
            $nbLitsSimples,
            $nbLitsDoubles,
            $type,
            $categorie,
            $pays,
            $etat
        );

        // Définition des champs facultatifs
        $formLogement->setNotRequiredFields(
            $numeroRue,
            $complementAdresse,
            $accroche,
            $description,
            $delaiResaArrivee,
            $dureeMinLoc,
            $delaiAnnulMax
        );

        header('Content-Type: application/json');

        // Mise à jour du logement dans la base de données avec la méthode update de la classe Logement
        try {
            $this->logement->updateLogementFromForm($formLogement, $idLogement);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Uniquement accessible avec la méthode POST']);
    }
}

    
    
        
}