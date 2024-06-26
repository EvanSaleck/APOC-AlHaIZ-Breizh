<?php

namespace Controllers;

include_once 'Models/Logement.php';
include_once 'Service/FormNewLogement.php';

use Models\Logement;
use Service\FormNewLogement;
use Exception;

class LogementController
{
    private $logement;
    private $newLogement;

    public function __construct()
    {
        $this->logement = new Logement();
    }

    public function getAllLogements()
    {
        $logements = $this->logement->getAllLogements();

        header('Content-Type: application/json');

        echo json_encode($logements);
    }

    public function getLogementsByProprietaireId($id)
    {
        $logements = $this->logement->getLogementsByProprietaireId($id);

        header('Content-Type: application/json');

        echo json_encode($logements);
    }

    public function getLogementById($id)
    {

        $logement = $this->logement->getLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($logement);
    }

    public function updateStatus($id, $status)
    {
        $logement = $this->logement->updateStatutLogement($id, $status);

        header('Content-Type: application/json');

        echo json_encode($logement);
    }
    public function getLogementsDataForCards()
    {
        $dataLogements = $this->logement->getLogementsDataForCards();

        header('Content-Type: application/json');

        echo json_encode($dataLogements);
    }

    public function getLogementDataById($id)
    {
        $logement = $this->logement->getLogementCompleteByID($id);

        header('Content-Type: application/json');

        echo json_encode($logement);
    }

    public function getAmenagementsOfLogementById($id)
    {
        $amenagements = $this->logement->getAmenagementsOfLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($amenagements);
    }

    public function getTypeOfLogementById($id)
    {
        $logements = $this->logement->getTypeOfLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($logements);
    }

    public function getCategorieOfLogementById($id)
    {
        $logements = $this->logement->getCategorieOfLogementById($id);

        header('Content-Type: application/json');

        echo json_encode($logements);
    }


    public function processFormNewLogement()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $tabNomRue = explode(' ', htmlentities($_POST['nom_rue']));
            if (is_numeric($tabNomRue[0])) {
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

    public function processFormUpdateLogement()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération de l'ID du logement à mettre à jour
            $idLogement = isset($_POST['id_logement']) ? intval($_POST['id_logement']) : null;
            if ($idLogement === null) {
                echo json_encode(['error' => 'ID du logement non fourni.']);
                return;
            }

            $tabNomRue = explode(' ', htmlentities($_POST['nom_rue']));
            if (is_numeric($tabNomRue[0])) {
                $numeroRue = $tabNomRue[0];
                $nomRue = '';
                for ($i = 1; $i < count($tabNomRue); $i++) {
                    $nomRue .= $tabNomRue[$i] . ' ';
                }
            } else {
                $numeroRue = null;
                $nomRue = htmlentities($_POST['nom_rue']);
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
            $arrayStatutPropriete = $this->logement->getStatutProprieteOfLogementById($idLogement);
            if (!empty($arrayStatutPropriete) && isset($arrayStatutPropriete[0]['statut_propriete'])) {
                $statutPropriete = $arrayStatutPropriete[0]['statut_propriete'];
            } else {
                $statutPropriete = false; // Valeur par défaut si aucune valeur n'est trouvée
            }

            $photo = $_POST['photo'] ?? null;

            // Création de l'objet FormNewLogement avec les données décodées
            $formLogement = new FormNewLogement(
                $titre,
                $tarif,
                $nomRue,
                $ville,
                $cp,
                $photo,
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

            $formLogement->setNotRequiredFields(
                $numeroRue,
                $complementAdresse,
                $accroche,
                $description,
                $delaiResaArrivee,
                $dureeMinLoc,
                $delaiAnnulMax,
                $statutPropriete
            );
            // Récupération de l'ID du logement à mettre à jour
            $idLogement = isset($_POST['id_logement']) ? intval($_POST['id_logement']) : null;
            if ($idLogement === null) {
                echo json_encode(['error' => 'ID du logement non fourni.']);
                return;
            }

                header('Content-Type: application/json');

                try {
                    $this->logement->updateLogementFromForm($formLogement, $idLogement);

                    if ($photo !== null) {
                        $this->db->update('logement', ['image_principale'], [$photo], 'id_logement', $idLogement);
                    }

                    echo json_encode(true);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Uniquement accessible avec la méthode POST']);

            }
        }
}