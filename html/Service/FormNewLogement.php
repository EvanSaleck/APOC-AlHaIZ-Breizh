<?php 
    namespace Service;

    include_once 'Models/Logement.php';

    use Models\Logement;
    use \Exception;

    class FormNewLogement {
        private $titre;
        private $tarif;
        private $noRue;
        private $nomRue;
        private $ville;
        private $cp;
        private $complementAdresse;
        private $amenagements;
        private $accroche;
        private $description;
        private $photo;
        private $surfaceHabitable;
        private $nbPersMax;
        private $nbChambres;
        private $nbLitsSimples;
        private $nbLitsDoubles;
        private $statutPropriete;
        private $avanceResaMin;
        private $dureeMinLocation;
        private $delaiAnnulMax;
        private $idType;
        private $idCategorie;
        private $pays;
        private $etat;

        private $logement;


        public function __construct(
            $titre,
            $tarif,
            $nomRue,
            $ville,
            $cp,
            $photo,
            $amenagements,
            $surfaceHabitable,
            $nbPersMax,
            $nbChambres,
            $nbLitsSimples,
            $nbLitsDoubles,
            $idType,
            $idCategorie,
            $pays,
            $etat
        ){
            $this->titre = $titre;
            $this->tarif = $tarif;
            $this->nomRue = $nomRue;
            $this->ville = $ville;
            $this->cp = $cp;
            $this->photo = $photo;
            $this->amenagements = $amenagements;
            $this->surfaceHabitable = $surfaceHabitable;
            $this->nbPersMax = $nbPersMax;
            $this->nbChambres = $nbChambres;
            $this->nbLitsSimples = $nbLitsSimples;
            $this->nbLitsDoubles = $nbLitsDoubles;
            $this->idType = $idType;
            $this->idCategorie = $idCategorie;
            $this->pays = $pays;
            $this->etat = $etat;

            $this->logement = new Logement();
        }
        
        // permet de set les champs non obligatoires
        public function setNotRequiredFields(
            $noRue,
            $complementAdresse,
            $accroche,
            $description,
            $avanceResaMin,
            $dureeMinLocation,
            $delaiAnnulMax,
            $statutPropriete = null
        ) {
            // on set seulement si les champs sont renseignés
            if (!empty($noRue)) {
                $this->setNoRue($noRue);
            }

            if (!empty($complementAdresse)) {
                $this->setComplementAdresse($complementAdresse);
            }

            if (!empty($accroche)) {
                $this->setAccroche($accroche);
            }

            if (!empty($description)) {
                $this->setDescription($description);
            }

            if (!empty($avanceResaMin)) {
                $this->setAvanceResaMin($avanceResaMin);
            }

            if (!empty($dureeMinLocation)) {
                $this->setDureeMinLocation($dureeMinLocation);
            }

            if (!empty($delaiAnnulMax)) {
                $this->setDelaiAnnulMax($delaiAnnulMax);
            }
            if (!empty($statutPropriete)) {
                $this->setStatutPropriete($statutPropriete);
            }
            
        }

        /**
         * Getters
         */

        public function getTitre() {
            return $this->titre;
        }

        public function getTarif() {
            return $this->tarif;
        }

        public function getNoRue() {
            return $this->noRue;
        }

        public function getNomRue() {
            return $this->nomRue;
        }

        public function getVille() {
            return $this->ville;
        }

        public function getCp() {
            return $this->cp;
        }

        public function getComplementAdresse() {
            return $this->complementAdresse;
        }

        public function getAmenagements() {
            return $this->amenagements;
        }

        public function getAccroche() {
            return $this->accroche;
        }

        public function getDescription() {
            return $this->description;
        }

        public function getPhoto() {
            return $this->photo;
        }

        public function getSurfaceHabitable() {
            return $this->surfaceHabitable;
        }

        public function getNbPersMax() {
            return $this->nbPersMax;
        }

        public function getNbChambres() {
            return $this->nbChambres;
        }

        public function getNbLitsSimples() {
            return $this->nbLitsSimples;
        }

        public function getNbLitsDoubles() {
            return $this->nbLitsDoubles;
        }

        public function getAvanceResaMin() {
            return $this->avanceResaMin;
        }

        public function getDureeMinLocation() {
            return $this->dureeMinLocation;
        }

        public function getDelaiAnnulMax() {
            return $this->delaiAnnulMax;
        }

        public function getIdType() {
            return $this->idType;
        }

        public function getIdCategorie() {
            return $this->idCategorie;
        }

        public function getPays() {
            return $this->pays;
        }

        public function getEtat() {
            return $this->etat;
        }

        public function getStatutPropriete() {
            return $this->statutPropriete;
        }
    

        /**
         * Setters
         */


        public function setTitre($titre) {
            $this->titre = $titre;

            return $this;
        }

        public function setTarif($tarif) {
            $this->tarif = $tarif;

            return $this;
        }

        public function setNoRue($noRue) {
            $this->noRue = $noRue;

            return $this;
        }

        public function setNomRue($nomRue) {
            $this->nomRue = $nomRue;

            return $this;
        }

        public function setVille($ville) {
            $this->ville = $ville;

            return $this;
        }

        public function setCp($cp) {
            $this->cp = $cp;

            return $this;
        }

        public function setComplementAdresse($complementAdresse) {
            $this->complementAdresse = $complementAdresse;

            return $this;
        }

        public function setAmenagements($amenagements) {
            $this->amenagements = $amenagements;

            return $this;
        }

        public function setAccroche($accroche) {
            $this->accroche = $accroche;

            return $this;
        }

        public function setDescription($description) {
            $this->description = $description;

            return $this;
        }

        public function setPhoto($photo) {
            $this->photo = $photo;

            return $this;
        }

        public function setSurfaceHabitable($surfaceHabitable) {
            $this->surfaceHabitable = $surfaceHabitable;

            return $this;
        }

        public function setNbPersMax($nbPersMax) {
            $this->nbPersMax = $nbPersMax;

            return $this;
        }

        public function setNbChambres($nbChambres) {
            $this->nbChambres = $nbChambres;

            return $this;
        }

        public function setNbLitsSimples($nbLitsSimples) {
            $this->nbLitsSimples = $nbLitsSimples;

            return $this;
        }

        public function setNbLitsDoubles($nbLitsDoubles) {
            $this->nbLitsDoubles = $nbLitsDoubles;

            return $this;
        }

        public function setStatutPropriete($statutPropriete) {
            $this->statutPropriete = $statutPropriete;

            return $this;
        }

        public function setAvanceResaMin($avanceResaMin) {
            $this->avanceResaMin = $avanceResaMin;

            return $this;
        }

        public function setDureeMinLocation($dureeMinLocation) {
            $this->dureeMinLocation = $dureeMinLocation;

            return $this;
        }

        public function setDelaiAnnulMax($delaiAnnulMax) {
            $this->delaiAnnulMax = $delaiAnnulMax;

            return $this;
        }

        public function setIdType($idType) {
            $this->idType = $idType;

            return $this;
        }

        public function setIdCategorie($idCategorie) {
            $this->idCategorie = $idCategorie;

            return $this;
        }

        public function setPays($pays) {
            $this->pays = $pays;

            return $this;
        }

        public function setEtat($etat) {
            $this->etat = $etat;

            return $this;
        }

        /**
         * permet de convertir l'objet en tableau
         */
        public function toArray(){
            return [
                'titre' => $this->titre,
                'tarif' => $this->tarif,
                'noRue' => $this->noRue,
                'nomRue' => $this->nomRue,
                'ville' => $this->ville,
                'cp' => $this->cp,
                'complementAdresse' => $this->complementAdresse,
                'amenagements' => $this->amenagements,
                'accroche' => $this->accroche,
                'description' => $this->description,
                'photo' => $this->photo,
                'surfaceHabitable' => $this->surfaceHabitable,
                'nbPersMax' => $this->nbPersMax,
                'nbChambres' => $this->nbChambres,
                'nbLitsSimples' => $this->nbLitsSimples,
                'nbLitsDoubles' => $this->nbLitsDoubles,
                'statutPropriete' => $this->statutPropriete,
                'avanceResaMin' => $this->avanceResaMin,
                'dureeMinLocation' => $this->dureeMinLocation,
                'delaiAnnulMax' => $this->delaiAnnulMax,
                'idType' => $this->idType,
                'idCategorie' => $this->idCategorie,
                'pays' => $this->pays,
                'etat' => $this->etat
            ];
        
        }

        /**
         * permet d'insérer le logement à partir de l'objet 
         */
        public function insert() {
            try {
                $this->logement->insertLogementFromForm($this);
            } catch (Exception $e){
                throw $e;
            }
        }

    }