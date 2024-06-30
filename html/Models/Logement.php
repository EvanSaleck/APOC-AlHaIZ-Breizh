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

    /**
     * Récupère tous les logements
     */
    public function getAllLogements() {
        $logements = $this->db->executeQuery('SELECT * FROM logement');

        return $logements;
    }

    /**
     * Récupère les logements d'un propriétaire
     */
    public function getLogementsByProprietaireId($id) {
        $logements = $this->db->executeQuery('SELECT * FROM logement WHERE L_id_compte = ' . $id);

        return $logements;
    }

    /**
     * Récupère un logement par son id
     */
    public function getLogementById($id) {

        $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);

        return $logement;
    }

    /**
     * Récupère les données de tous les logements pour les afficher dans des cards de la page d'accueil
     */
    public function getLogementsDataForCards($startDate = null, $endDate = null) {
        // $query = '
        // select  l.id_logement,
        //         l.titre,
        //         l.description,
        //         l.image_principale,
        //         l.prix_nuit_ttc,
        //         ad.nom_ville,
        //         ad.code_postal,
        //         avg(av.note_avis) as moyenne_logement, 
        //         count(av.id_avis) as nb_avis
        //     from logement l 
        //         inner join adresse ad
        //             on l.l_id_adresse  = ad.id_adresse 
        //     left join reservation r 
        //         on l.id_logement = r.r_id_logement 
        //     left join avis av
        //         on r.id_reservation = av.av_id_reservation 
        //     group by (l.id_logement,ad.id_adresse);
        // ';
        
        // meme requete que la précédente mais en prenant l'id, nom et prenom du propriétaire en mem temps
        $query = '
        select  l.id_logement,
                l.titre,
                l.description,
                l.image_principale,
                l.prix_nuit_ttc,
                ad.nom_ville,
                ad.code_postal,
                avg(av.note_avis) as moyenne_logement, 
                count(av.id_avis) as nb_avis,
                c.id_compte,
                c.nom,
                c.prenom
            from logement l 
                inner join adresse ad
                    on l.l_id_adresse  = ad.id_adresse 
                inner join compte_proprietaire c
                    on l.L_id_compte = c.id_compte
            left join reservation r 
                on l.id_logement = r.r_id_logement 
            left join avis av
                on r.id_reservation = av.av_id_reservation 
            group by (l.id_logement,ad.id_adresse,c.id_compte);
        ';
        
        
        // on créé une query qu'on module en fonction de la date de début et de fin 
        // // on rajoute le where des date que si elles sont renseignées (différentes de null)
        // $query = '
        //     select l.id_logement,
        //             l.titre,
        //             l.description,
        //             l.image_principale,
        //             l.prix_nuit_ttc,
        //             ad.nom_ville,
        //             ad.code_postal,
        //             avg(av.note_avis) as moyenne_logement, 
        //             count(av.id_avis) as nb_avis
        //         from logement l 
        //             inner join adresse ad
        //                 on l.l_id_adresse  = ad.id_adresse 
        //         left join reservation r 
        //             on l.id_logement = r.r_id_logement 
        //         left join avis av
        //             on r.id_reservation = av.av_id_reservation ';

        // // on utilise isDisponible pour savoir si le logement est disponible pour la période donnée
        // if ($startDate != 'null' && $endDate != 'null') {
        //     $query .= 'where l.id_logement in (
        //         select l.id_logement
        //         from logement l
        //         where l.id_logement not in (
        //             select r.r_id_logement
        //             from reservation r
        //             where r.date_arrivee <= \'' . $endDate . '\' and r.date_depart >= \'' . $startDate . '\'
        //         )
        //     ) ';
        // }

        // $query .= 'group by (l.id_logement,ad.id_adresse);';

        $dataLogements = $this->db->executeQuery($query);

        return $dataLogements;
    }

    // retourne la liste des id de logements disponibles pour une période donnée
    public function getLogementsDispo($startDate, $endDate) {
        $query = '
        select l.id_logement
        from logement l
        where l.id_logement not in (
            select r.r_id_logement
            from reservation r
            where r.date_arrivee <= \'' . $endDate . '\' and r.date_depart >= \'' . $startDate . '\'
        )';

        $listeLogements = $this->db->executeQuery($query);
        
        return $listeLogements;
    }

    // renvoie un boolean en fonction de si le logement est disponible pour une période donnée
    public function isDisponible($id,string $dateDebut, string $dateFin) {
        $query = '
        select l.id_logement
        from logement l
        where l.id_logement not in (
            select r.r_id_logement
            from reservation r
            where r.date_arrivee <= \'' . $dateFin . '\' and r.date_depart >= \'' . $dateDebut . '\'
        ) and l.id_logement = ' . $id;

        $logementDispo = $this->db->executeQuery($query);

        return count($logementDispo) > 0;
    }

    /**
     * Récupère les logements d'un abonnement
     */
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

    /**
     * verifie si un logement existe
     */
    public function logementExists($id) {
        $logement = $this->db->executeQuery('SELECT * FROM logement WHERE id_logement = ' . $id);
        return count($logement) > 0;
    }

    /**
     * Insert un logement à partir d'un formulaire
     */
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

            // print_r($valeursAdresse);


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
            $idProrietaire = json_decode($_SESSION['proprio'])->id_compte;

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
            
            // on ajoute les valeurs du logement    
            $valeursLogement[] = $formLogement->getTitre();
            $valeursLogement[] = $coordonnees[0];
            $valeursLogement[] = $coordonnees[1];
            $valeursLogement[] = $formLogement->getSurfaceHabitable();
            $valeursLogement[] = $formLogement->getNbPersMax();
            $valeursLogement[] = $formLogement->getNbChambres();
            $valeursLogement[] = $formLogement->getNbLitsSimples();
            $valeursLogement[] = $formLogement->getNbLitsDoubles();
            // statut propriété
            $valeursLogement[] = 'false';
            $valeursLogement[] = $formLogement->getTarif();
            // prix nuit ttc
            $valeursLogement[] = $formLogement->getTarif() * (1 + self::TAUX_TVA); 
            $valeursLogement[] = $idProrietaire;
            $valeursLogement[] = $this->db->getPDO()->lastInsertId();
            $valeursLogement[] = $formLogement->getIdType();
            $valeursLogement[] = $formLogement->getIdCategorie();
            // print_r($valeursLogement);

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

            // on insere le logement en fonction des champs et valeurs qui ont été renseignés 
            $this->db->insert('logement', $colonnesLogement, $valeursLogement);

            // on récupère l'id du logement (dernier insert)
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

    /**
     *  Met à jour un logement à partir d'un formulaire
     */
    public function updateLogementFromForm($formLogement, $idLogement) {
    try {
        $this->db->getPDO()->beginTransaction();
        try {
            // Utilisation de la méthode executeQuery pour récupérer l'ID de l'adresse
            $adresseID = $this->db->executeQuery("SELECT L_id_adresse FROM logement WHERE id_logement =?", [$idLogement]);

            if (!empty($adresseID)) {
                $firstRow = $adresseID[0];

                $adresseId = $firstRow["l_id_adresse"];
            } else {
                echo "Aucun résultat trouvé pour l'ID de logement : $idLogement\n";
                throw new Exception("Aucun résultat trouvé pour l'ID de logement : $idLogement");
            }
        } catch (\Exception $e) {
            echo "Erreur lors de la récupération de l'ID de l'adresse : ". $e->getMessage();
            return; // Arrêter l'exécution ici si une exception est levée
        }
        
        $numeroRue = null; // Initialisation de la variable
        if ($formLogement->getNoRue()!= '' && is_numeric($formLogement->getNoRue())) {
            $numeroRue = $formLogement->getNoRue();
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
        if ($formLogement->getNoRue()!= '') {
            $colonnesAdresse[] = 'numero_rue';
            $valeursAdresse[] = $formLogement->getNoRue();
        }
        
        if ($formLogement->getComplementAdresse()!= '') {
            $colonnesAdresse[] = 'complement';
            $valeursAdresse[] = $formLogement->getComplementAdresse();
        }
        
        if ($formLogement->getEtat()!= '') {
            $colonnesAdresse[] = 'etat';
            $valeursAdresse[] = $formLogement->getEtat();
        }
        
        if ($adresseId!== null) {
            $this->db->update('adresse', $colonnesAdresse, $valeursAdresse, 'id_adresse', $adresseId);
        } else {
            // Gérer le cas où l'ID de l'adresse n'est pas trouvé
            throw new Exception('Adresse non trouvée pour le logement.'); // Lancer une exception si l'ID de l'adresse est null
        }
        
        
        



        // Colonnes et valeurs du logement
        $colonnesLogement = [
            'titre',
            'surface_hab',
            'personnes_max',
            'nb_chambres',
            'nb_lits_simples',
            'nb_lits_doubles',
            'prix_nuit_ttc',
            //'L_id_compte',
            'L_id_type',
            'L_id_categorie'
        ];

        // $idProprietaire = $_SESSION['Proprio']['id_compte'];

        $valeursLogement = [
            $formLogement->getTitre(),
            $formLogement->getSurfaceHabitable(),
            $formLogement->getNbPersMax(),
            $formLogement->getNbChambres(),
            $formLogement->getNbLitsSimples(),
            $formLogement->getNbLitsDoubles(),
            $formLogement->getTarif(),
            // $idProprietaire,
            $formLogement->getIdType(),
            $formLogement->getIdCategorie()
        ];



        if ($formLogement->getAccroche() != '') {
            $colonnesLogement[] = 'accroche';
            $valeursLogement[] = $formLogement->getAccroche();
        }

        if ($formLogement->getDescription() != '') {
            $colonnesLogement[] = 'description';
            $valeursLogement[] = $formLogement->getDescription();
        }

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

        $this->db->update('logement', $colonnesLogement, $valeursLogement, 'id_logement', $idLogement);
        
         // Gestion de la photo
         if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $dossier = './assets/imgs/logements/';
            $extension = pathinfo($_FILES['photo']['name'])['extension'];
            $fichier = $dossier . 'image_' . $idLogement . '.' . $extension;

            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $fichier)) {
                throw new Exception('Erreur lors de l\'upload de la photo. :,(');
            }

            // Mise à jour du nom de la photo
            $this->db->update('logement', ['image_principale'], [substr($fichier, 1)], 'id_logement', $idLogement);
        }

        // Mise à jour des aménagements
        $amenagements = json_decode($formLogement->getAmenagements());
        //var_dump($amenagements);
        if (isset($amenagements)) {
            // Récupérer les aménagements existants
            $existingAmenagements = $this->db->select('amenagements_logement', ['al_id_amenagement'], ['al_id_logement' => $idLogement]);
            $existingAmenagements = array_column($existingAmenagements, 'al_id_amenagement');

            // Ajouter les nouveaux aménagements et conserver les aménagements existants
            foreach ($amenagements as $amenagement) {
                if (!in_array($amenagement, $existingAmenagements)) {
                    $this->db->insert('amenagements_logement', ['al_id_logement', 'al_id_amenagement'], [$idLogement, $amenagement]);
                }
            }

            // Supprimer les aménagements qui ne sont plus dans la liste
            foreach ($existingAmenagements as $existingAmenagement) {
                if (!in_array($existingAmenagement, $amenagements)) {
                    $this->db->executeQuery("DELETE FROM amenagements_logement WHERE al_id_logement = ? AND al_id_amenagement = ?", [$idLogement, $existingAmenagement]);
                }
            }
        }

        $this->db->getPDO()->commit();

        return true;
    } catch (Exception $e) {
        $this->db->getPDO()->rollBack();
        throw new Exception('Erreur lors de la mise à jour des données : ' . $e->getMessage());
    }
}

    
    /**
     * renvoie les données d'un logement avec son adresse
     */
    public function getLogementCompleteByID($id) {
        $logements = $this->db->executeQuery('
        SELECT * 
        FROM logement 
        JOIN adresse ON l_id_adresse = id_adresse
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    /**
     * renvoie les aménagements d'un logement
     */
    public function getAmenagementsOfLogementById($id) {
        $logements = $this->db->executeQuery('
        SELECT id_amenagement, nom_amenagement
        FROM logement
        JOIN amenagements_logement ON id_logement = al_id_logement
        JOIN amenagement ON al_id_amenagement = id_amenagement
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    /**
     * renvoie le type de logement à partir d'un id
     */
    public function getTypeOfLogementById($id) {
        $logements = $this->db->executeQuery('
        SELECT id_type, nom_type
        FROM logement 
        JOIN type_logement ON L_id_type = id_type
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    /**
     * renvoie la catégorie de logement à partir d'un id
     */
    public function getCategorieOfLogementById($id) {
        $logements = $this->db->executeQuery('
        SELECT id_categorie, nom_categorie
        FROM logement 
        JOIN categorie_logement ON L_id_categorie = id_categorie
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    /**
     * renvoie le status d'un logement à partir de son id
     */
    public function getStatutProprieteOfLogementById($id) {
        $logements = $this->db->executeQuery('
        SELECT statut_propriete
        FROM logement 
        
        WHERE id_logement = ' . $id);
        
        return $logements;
    }

    /**
     * renvoie la liste des communes liés à des logements
     */
    public function getCommunes() {
        $communes = $this->db->executeQuery('SELECT DISTINCT nom_ville FROM adresse');
        return $communes;
    }

    /**
     * met à jour le statut d'un logement
     */
    public function updateStatutLogement($id, $nouveauStatut) {
        $sql = 'UPDATE logement SET statut_propriete = ? WHERE id_logement =?';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$nouveauStatut, $id]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }
}