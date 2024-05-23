<?php
    namespace Models;

namespace Models;

include_once 'Service/Database.php';

use Service\Database;
use \Exception;

class Logement {
    // constante du montant pour passer du ht au ttc
    const TAUX_TVA = 0.1; 

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function insertLogementFromForm($formLogement) {
        try {
            $this->db->getPDO()->beginTransaction();

            /**Colonnes et valeurs de l'adresse */
            $colonnesAdresse = [
                'numero_rue',
                'nom_rue',
                'code_postal',
                'nom_ville',
                'pays'
            ];
            $valeursAdresse = [];

            if ($formLogement->getNoRue() != '') {
                $valeursAdresse[] = $formLogement->getNoRue();
            }
            $valeursAdresse[] = $formLogement->getNomRue();
            $valeursAdresse[] = $formLogement->getCp();
            $valeursAdresse[] = $formLogement->getVille();
            $valeursAdresse[] = $formLogement->getPays();

            if ($formLogement->getComplementAdresse() != '') {
                $colonnesAdresse[] = 'complement_adresse';
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

            $valeursLogement[] = $formLogement->getTitre();
            $valeursLogement[] = 0;
            $valeursLogement[] = 0;
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
                $valeursLogement[] = $formLogement->getDelaiResaArrivee();
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
                $dossier = 'assets/imgs/logements/';
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
            $this->db->update('logement', ['image_principale'], [$fichier], 'id_logement', $idLogement);

            // amenagement est un tableau json
            $amenagements = json_decode($formLogement->getAmenagements());

            foreach ($amenagements as $amenagement) {
                $this->db->insert('amenagements_logement', ['al_id_logement', 'al_id_amenagement'], [$idLogement, $amenagement]);
            }

            $this->db->getPDO()->commit();

        } catch (Exception $e) {
            $this->db->getPDO()->rollBack();
            throw new Exception('Erreur lors de l\'insertion des données : ' . $e->getMessage());
            return false;
        }

        return true;
    }
}