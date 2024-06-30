<?php 

namespace Service;

class MapsService {
    private $api_key;

    public function __construct() {
        // on récupère la clé api pour les services google maps
        // NE PAS FAIRE DE REQUETE INUTILE VERS L'API GOOGLE MAPS, J'AI (LUCAS) MIS MA CARTE 
        // AVEC UN NOMBRE LIMITE DE REQUETES DONC TROP DE REQUETE -> PLUS D'INSERTION DE LOGEMENTS
        $this->api_key = 'AIzaSyArNdHq1l2treAyeuvDSK33dNQf0YXSGyA';
    }

    /**
     * Convertit une adresse en chaine de caractères
     */
    public function adresseToString($noRue, $nomRue, $ville, $codePostal ,$pays, $etat){
        $adresse = $noRue ? $noRue . ' ' : '';

        $adresse .= $nomRue . ', ' . $ville . ', ' . $codePostal . ', ' . $pays;

        $adresse = $etat ? $etat . ' ' : '';
        
        return $adresse;
    }

    /**
     * Récupère les coordonnées géographiques d'une adresse à partir de l'API Google Maps
     */
    public function getCoordinatesFromAddress($address) {
        $tab = [null,null];
        
        $encoded_address = urlencode($address);

        // on initilalise l'url de l'api 
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encoded_address}&key={$this->api_key}";

        // on récupère la réponse de l'appel api
        $response = file_get_contents($url);

        // on decode la réponse
        $data = json_decode($response, true);

        // on vérifie que la réponse est bien OK
        if ($data['status'] === 'OK') {
            // on récupère les coordonnées
            $latitude = $data['results'][0]['geometry']['location']['lat'];
            $longitude = $data['results'][0]['geometry']['location']['lng'];

            $tab = [$latitude,$longitude];
        } 

        return $tab;
    }
}