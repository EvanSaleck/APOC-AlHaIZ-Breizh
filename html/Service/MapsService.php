<?php 

namespace Service;

class MapsService {
    private $api_key;

    public function __construct() {
        $this->api_key = 'AIzaSyArNdHq1l2treAyeuvDSK33dNQf0YXSGyA';
    }

    public function adresseToString($noRue, $nomRue, $ville, $codePostal ,$pays, $etat){
        $adresse = $noRue ? $noRue . ' ' : '';

        $adresse .= $nomRue . ', ' . $ville . ', ' . $codePostal . ', ' . $pays;

        $adresse = $etat ? $etat . ' ' : '';
        
        return $adresse;
    }

    public function getCoordinatesFromAddress($address) {
        $tab = [null,null];
        
        $encoded_address = urlencode($address);

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encoded_address}&key={$this->api_key}";

        $response = file_get_contents($url);

        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {
            $latitude = $data['results'][0]['geometry']['location']['lat'];
            $longitude = $data['results'][0]['geometry']['location']['lng'];

            $tab = [$latitude,$longitude];
        } 

        return $tab;
    }
}