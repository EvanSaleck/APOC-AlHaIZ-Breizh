<?php 

namespace Service;

include_once 'Models/Reservation.php';
include_once 'Models/AbonnementICal.php';
include_once 'Models/Logement.php';

use Models\Reservation;
use Models\AbonnementICal;
use Models\Logement;

class ICalService {

    private $reservationModel;
    private $logementModel;

    public function __construct() {
        $this->reservationModel = new Reservation();
        $this->logementModel = new Logement();
    }

    public function generateFileWithToken($token) {
        $abonnement = new AbonnementICal();
        $abonnement = $abonnement->getAbonnementByToken($token);
        
        $dateDebut = $abonnement[0]['date_debut'];
        $dateFin = $abonnement[0]['date_fin'];
        $sequence = $abonnement[0]['nb_modifications'];

        $logements = $this->logementModel->getLogementsByAbonnement($abonnement[0]['id_abonnement']);

        $idsLogements = [];
        foreach($logements as $logement) {
            $idsLogements[] = $logement['id_logement'];
        }
       
        
        $reservations = $this->reservationModel->getReservationsForExportICal($dateDebut, $dateFin, $idsLogements);

        $reservationICal =  $this->getReservationsIcal($reservations,$sequence);
        
        $file = fopen("icalfiles/$token.ics", "w");
        fwrite($file, $reservationICal);
        fclose($file);

        return $reservationICal;
    }

    public function urlFromToken($token) {
        $server = $_SERVER['HTTP_HOST'];
        $url = "http://$server/icalfiles/$token.ics";
        return $url;
    }

    public function getReservationsIcal($reservations, $sequence) {
        $ical = "BEGIN:VCALENDAR\n";
        $ical .= "VERSION:2.0\n";
        $ical .= "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n";     
        $ical .= "CALSCALE:GREGORIAN\n";
        $ical .= "METHOD:PUBLISH\n";
        $ical .= "X-WR-CALNAME:Reservations\n";
        $ical .= "X-WR-TIMEZONE:Europe/Paris\n";
        $ical .= "X-WR-CALDESC:Reservations\n";

        foreach($reservations as $reservation) {
            $ical .= "BEGIN:VEVENT\n";
            $ical .= "DTSTART:" . date('Ymd', strtotime($reservation['date_arrivee'])) . "\n";
            $ical .= "DTEND:" . date('Ymd', strtotime($reservation['date_depart'])) . "\n";
            // summary = nom du logement
            $ical .= "SUMMARY:" . $reservation['titre'] . "\n";
            $ical .= "DESCRIPTION:Nom du client: " . $reservation['pseudo'] . "\\nEmail: " . $reservation['e_mail'] . "\\nTarif total: " . $reservation['tarif_total'] . "\n";
            $ical .= "LOCATION:" . $reservation['numero_rue'] . ", " . $reservation['nom_rue'] . ", " . $reservation['nom_ville'] . $reservation['code_postal'] . " " . $reservation['nom_ville'] . "\n";
            $ical .= "STATUS:CONFIRMED\n";
            $ical .= "END:VEVENT\n";
        }

        $ical .= "SEQUENCE:" . $sequence . "\n";
        $ical .= "END:VCALENDAR";

        return $ical;
    }

    public function formatAbonnementTab($id) {
        $abonnementFormat = [];

        $abonnement = new AbonnementICal();

        $abonnements = $abonnement->getAbonnementsByProprietaire($id);

        $server = $_SERVER['HTTP_HOST'];
                
        foreach($abonnements as $key => $abonnement) {
            $abonnementFormat[$key]['id'] = $abonnement['id_abonnement'];

            $abonnementFormat[$key]['titre_abo'] = $abonnement['titre'];

            $abonnementFormat[$key]['date_debut'] = date('d/m/Y', strtotime($abonnement['date_debut']));
            $abonnementFormat[$key]['date_fin'] = date('d/m/Y', strtotime($abonnement['date_fin']));
            
            $logements = $this->logementModel->getLogementsByAbonnement($abonnement['id_abonnement']);
            $abonnementFormat[$key]['logements'] = $logements; 

            $token = $abonnement['token'];
            $url = "http://$server/reservations/abonnement?token=" . $token;
            $abonnementFormat[$key]['url'] = $url;
            $abonnementFormat[$key]['dateCreation'] = date('d/m/Y', strtotime($abonnement['date_creation']));
        }

        return $abonnementFormat;
    }
}