<?php

namespace Models;

class Logement {
    private $id_logement;
    private $titre;
    private $accroche;
    private $personnes_max;
    private $image_principale;
    private $description;
    private $latitude;
    private $longitude;
    private $surface_hab;
    private $nb_chambres;
    private $nb_lits_simples;
    private $nb_lits_doubles;
    private $prix_nuit_ht;
    private $prix_nuit_ttc;
    private $statut_propriete;
    private $duree_min_location;
    private $avance_resa_min;
    private $delai_annul_max;
    private $L_id_adresse;
    private $L_id_compte;
    private $L_id_type;
    private $L_id_categorie;

    // Constructeur
    public function __construct($id_logement, $titre, $accroche, $personnes_max, $image_principale, $description, 
                                $latitude, $longitude, $surface_hab, $nb_chambres, $nb_lits_simples, $nb_lits_doubles, 
                                $prix_nuit_ht, $prix_nuit_ttc, $statut_propriete, $duree_min_location, $avance_resa_min, 
                                $delai_annul_max, $L_id_adresse, $L_id_compte, $L_id_type, $L_id_categorie) {
        $this->id_logement = $id_logement;
        $this->titre = $titre;
        $this->accroche = $accroche;
        $this->personnes_max = $personnes_max;
        $this->image_principale = $image_principale;
        $this->description = $description;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->surface_hab = $surface_hab;
        $this->nb_chambres = $nb_chambres;
        $this->nb_lits_simples = $nb_lits_simples;
        $this->nb_lits_doubles = $nb_lits_doubles;
        $this->prix_nuit_ht = $prix_nuit_ht;
        $this->prix_nuit_ttc = $prix_nuit_ttc;
        $this->statut_propriete = $statut_propriete;
        $this->duree_min_location = $duree_min_location;
        $this->avance_resa_min = $avance_resa_min;
        $this->delai_annul_max = $delai_annul_max;
        $this->L_id_adresse = $L_id_adresse;
        $this->L_id_compte = $L_id_compte;
        $this->L_id_type = $L_id_type;
        $this->L_id_categorie = $L_id_categorie;
    }

    // Getters
    public function getIdLogement() { return $this->id_logement; }
    public function getTitre() { return $this->titre; }
    public function getAccroche() { return $this->accroche; }
    public function getPersonnesMax() { return $this->personnes_max; }
    public function getImagePrincipale() { return $this->image_principale; }
    public function getDescription() { return $this->description; }
    public function getLatitude() { return $this->latitude; }
    public function getLongitude() { return $this->longitude; }
    public function getSurfaceHab() { return $this->surface_hab; }
    public function getNbChambres() { return $this->nb_chambres; }
    public function getNbLitsSimples() { return $this->nb_lits_simples; }
    public function getNbLitsDoubles() { return $this->nb_lits_doubles; }
    public function getPrixNuitHt() { return $this->prix_nuit_ht; }
    public function getPrixNuitTtc() { return $this->prix_nuit_ttc; }
    public function getStatutPropriete() { return $this->statut_propriete; }
    public function getDureeMinLocation() { return $this->duree_min_location; }
    public function getAvanceResaMin() { return $this->avance_resa_min; }
    public function getDelaiAnnulMax() { return $this->delai_annul_max; }
    public function getLIdAdresse() { return $this->L_id_adresse; }
    public function getLIdCompte() { return $this->L_id_compte; }
    public function getLIdType() { return $this->L_id_type; }
    public function getLIdCategorie() { return $this->L_id_categorie; }

    // Méthode pour renvoyer les données sous forme de tableau
    public function toArray() {
        return [
            'id_logement' => $this->id_logement,
            'titre' => $this->titre,
            'accroche' => $this->accroche,
            'personnes_max' => $this->personnes_max,
            'image_principale' => $this->image_principale,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'surface_hab' => $this->surface_hab,
            'nb_chambres' => $this->nb_chambres,
            'nb_lits_simples' => $this->nb_lits_simples,
            'nb_lits_doubles' => $this->nb_lits_doubles,
            'prix_nuit_ht' => $this->prix_nuit_ht,
            'prix_nuit_ttc' => $this->prix_nuit_ttc,
            'statut_propriete' => $this->statut_propriete,
            'duree_min_location' => $this->duree_min_location,
            'avance_resa_min' => $this->avance_resa_min,
            'delai_annul_max' => $this->delai_annul_max,
            'L_id_adresse' => $this->L_id_adresse,
            'L_id_compte' => $this->L_id_compte,
            'L_id_type' => $this->L_id_type,
            'L_id_categorie' => $this->L_id_categorie
        ];
    }
}