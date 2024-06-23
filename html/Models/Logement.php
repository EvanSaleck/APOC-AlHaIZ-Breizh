<?php

namespace Models;

include_once 'Service/Database.php';
include_once 'Service/MapsService.php';

use Service\Database;
use Service\MapsService;
use \Exception;

class Logement {
    // constante du montant pour passer du ht au ttc
    const TAUX_TVA = 0.1; 
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->getPDO(); 
    }

    public function getAllLogements() {
        $logements = $this->db->executeQuery('SELECT * FROM logement');

        return $logements;
    }

    public function getLogementsByProprietaireId($id) {
        $logements = $this->db->executeQuery('SELECT * FROM logement WHERE L_id_compte = ' . $id);

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

    public function getLogementsByAbonnement($id){
        // on selectionne seulement le contenu de la table logement
        $logements = $this->db->executeQuery('
        SELECT l.*
        FROM logement l
        JOIN logement_abonnement ON id_logement = LA_id_logement
        JOIN abonnements_reservations ON LA_id_abonnement = id_abonnement
        WHERE id_abonnement = ' . $id);
                
        return $logements;
    }

    public function logementExists($id) {
        $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
        return count($logement) > 0;
    }

    public function insertLogementFromForm($formLogement) {
        try {
            $this->db->getPDO()->beginTransaction();

            
            if ($formLogement->getNoRue() != '' && is_numeric($formLogement->getNoRue())) {
                $numeroRue = $formLogement->getNoRue();
                
                // on fait en sorte que le nom de rue ne compporte pas le numéro de rue
            } else {
                $numeroRue = null;
            }
            
            /**Colonnes et valeurs de l'adresse */
            $colonnesAdresse = [
                'nom_rue',
                'code_postal',
                'nom_ville',
                'pays'
            ];
            $valeursAdresse = [];
            
            
            $valeursAdresse[] = $formLogement->getNomRue();
            $valeursAdresse[] = $formLogement->getCp();
            $valeursAdresse[] = $formLogement->getVille();
            $valeursAdresse[] = $formLogement->getPays();
            
            // on ajoute le numéro de rue seulement si c'est un chiffre
            if ($formLogement->getNoRue() != '') {
                $colonnesAdresse[] = 'numero_rue';
                $valeursAdresse[] = $formLogement->getNoRue();
            }
            


            if ($formLogement->getComplementAdresse() != '') {
                $colonnesAdresse[] = 'complement';
                $valeursAdresse[] = $formLogement->getComplementAdresse();
            }

            if ($formLogement->getEtat() != '') {
                $colonnesAdresse[] = 'etat';
                $valeursAdresse[] = $formLogement->getEtat();
            }

            $this->db->insert('adresse', $colonnesAdresse, $valeursAdresse);

            /** Colonnes et valeurs du logement */
            $colonnesLogement = [
                'titre',
                'latitude',
                'longitude',
                'surface_hab',
                'personnes_max',
                'nb_chambres',
                'nb_lits_simples',
                'nb_lits_doubles',
                'statut_propriete',
                'prix_nuit_ht',
                'prix_nuit_ttc',
                'L_id_compte',
                'L_id_adresse',
                'L_id_type',
                'L_id_categorie'
            ];

            $valeursLogement = [];
            // $idProrietaire = $_SESSION['Proprio']['id_compte'];
            $idProrietaire = 7;

            try {
                // on initialise la chaine de caractère de l'adresse
                $adresse = $formLogement->getNoRue() . ' ' . $formLogement->getNomRue() . ', ' . $formLogement->getVille() . ', ' . $formLogement->getCp() . ', ' . $formLogement->getPays();
                
                // Vérifier si les parties nécessaires de l'adresse ne sont pas vides
                if (empty($formLogement->getNoRue()) || empty($formLogement->getNomRue()) || empty($formLogement->getVille()) || empty($formLogement->getCp()) || empty($formLogement->getPays())) {
                    throw new Exception("Certaines parties de l'adresse sont manquantes.");
                }
            
                $mapsService = new MapsService();
                $coordonnees = $mapsService->getCoordinatesFromAddress(trim($adresse));
            
                // Vérifier si les coordonnées ont bien été récupérées
                if (empty($coordonnees)) {
                    throw new Exception("Les coordonnées n'ont pas pu être récupérées pour l'adresse fournie.");
                }
            
            } catch (Exception $e) {
                // Gestion des exceptions
                echo 'Erreur : ' . $e->getMessage();
            }            

            $valeursLogement[] = $formLogement->getTitre();
            $valeursLogement[] = $coordonnees[0];
            $valeursLogement[] = $coordonnees[1];
            $valeursLogement[] = $formLogement->getSurfaceHabitable();
            $valeursLogement[] = $formLogement->getNbPersMax();
            $valeursLogement[] = $formLogement->getNbChambres();
            $valeursLogement[] = $formLogement->getNbLitsSimples();
            $valeursLogement[] = $formLogement->getNbLitsDoubles();
            // statut propriété
            $valeursLogement[] = true;
            $valeursLogement[] = $formLogement->getTarif();
            // prix nuit ttc
            $valeursLogement[] = $formLogement->getTarif() * (1 + self::TAUX_TVA); 
            $valeursLogement[] = $idProrietaire;
            $valeursLogement[] = $this->db->getPDO()->lastInsertId();
            $valeursLogement[] = $formLogement->getIdType();
            $valeursLogement[] = $formLogement->getIdCategorie();

            // accroche 
            if ($formLogement->getAccroche() != '') {
                $colonnesLogement[] = 'accroche';
                $valeursLogement[] = $formLogement->getAccroche();
            }

            // description
            if ($formLogement->getDescription() != '') {
                $colonnesLogement[] = 'description';
                $valeursLogement[] = $formLogement->getDescription();
            }

            // conditions de réservation
            if ($formLogement->getAvanceResaMin() != '') {
                $colonnesLogement[] = 'avance_resa_min';
                $valeursLogement[] = $formLogement->getAvanceResaMin();
            }

            if ($formLogement->getDureeMinLocation() != '') {
                $colonnesLogement[] = 'duree_min_location';
                $valeursLogement[] = $formLogement->getDureeMinLocation();
            }

            if ($formLogement->getDelaiAnnulMax() != '') {
                $colonnesLogement[] = 'delai_annul_max';
                $valeursLogement[] = $formLogement->getDelaiAnnulMax();
            }

            
            $this->db->insert('logement', $colonnesLogement, $valeursLogement);

            // Amenagements
            $idLogement = $this->db->getPDO()->lastInsertId();


            // on gère l'insert de la photo après avoir eu l'id du logement
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $dossier = './assets/imgs/logements/';
                $extension = pathinfo($_FILES['photo']['name'])['extension'];
                $fichier = $dossier . 'image_' . $idLogement . '.' . $extension;
                
                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $fichier)) {
                    throw new Exception('Erreur lors de l\'upload de la photo. :,(');
                    return false;
                }
            } else {
                throw new Exception('Erreur dans le file error ou pas de file set.');
                return false;
            }

            // on update le logement avec le nom de la photo
            $this->db->update('logement', ['image_principale'], [substr($fichier,1)], 'id_logement', $idLogement);

            // amenagement est un tableau json
            $amenagements = json_decode($formLogement->getAmenagements());

            if(isset($amenagements)){
                foreach ($amenagements as $amenagement) {
                    $this->db->insert('amenagements_logement', ['al_id_logement', 'al_id_amenagement'], [$idLogement, $amenagement]);
                }
            }

            $this->db->getPDO()->commit();

        } catch (Exception $e) {
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de l\'insertion des données : ' . $e->getMessage());
            return false;
        }

        return true;
    }

    public function getLogementCompleteByID($id) {
        $logements = $this->db->executeQuery('
        SELECT * 
        FROM logement 
        JOIN adresse ON l_id_adresse = id_adresse
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    public function getAmenagementsOfLogementById($id) {
        $logements = $this->db->executeQuery('
        SELECT id_amenagement, nom_amenagement
        FROM logement
        JOIN amenagements_logement ON id_logement = al_id_logement
        JOIN amenagement ON al_id_amenagement = id_amenagement
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    public function getTypeOfLogementById($id) {
        $logements = $this->db->executeQuery('
        SELECT id_type, nom_type
        FROM logement 
        JOIN type_logement ON L_id_type = id_type
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    public function getCategorieOfLogementById($id) {
        $logements = $this->db->executeQuery('
        SELECT id_categorie, nom_categorie
        FROM logement 
        JOIN categorie_logement ON L_id_categorie = id_categorie
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    

    public function updateStatutLogement($id, $nouveauStatut) {
        // Correction de la syntaxe SQL pour l'insertion de variables
        $sql = 'UPDATE logement SET statut_propriete = ? WHERE id_logement =?';
        
        // Préparation et exécution de la requête
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$nouveauStatut, $id]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        
        // Retourner le nombre de lignes affectées
        return $result;
    }
    
    

    
    
}