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

    // export iCal with url and token
    public function generateFileWithToken($token) {
        // $dateDebut = $form['dateDebut'];
        // $dateFin = $form['dateFin'];
        // $logements = $form['logements'];

        // on récupère l'abonnement
        $abonnement = new AbonnementICal();
        $abonnement = $abonnement->getAbonnementByToken($token);
        
        $dateDebut = $abonnement[0]['date_debut'];
        $dateFin = $abonnement[0]['date_fin'];

        $logements = $this->logementModel->getLogementsByAbonnement($abonnement[0]['id_abonnement']);

        $idsLogements = [];
        foreach($logements as $logement) {
            $idsLogements[] = $logement['id_logement'];
        }
       
        
        $reservations = $this->reservationModel->getReservationsForExportICal($dateDebut, $dateFin, $idsLogements);

        $reservationICal =  $this->getReservationsIcal($reservations);
        
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

    public function getReservationsIcal($reservations) {
        // echo '<pre>';
        // print_r($reservations);
        // echo '</pre>';
        // die();
        
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
            $ical .= "SUMMARY:Reservation\n";
            $ical .= "DESCRIPTION:Reservation\n";
            $ical .= "STATUS:reservation_confirmee\n";
            $ical .= "END:VEVENT\n";
        }

        $ical .= "END:VCALENDAR";

        // echo '<pre>';
        // var_dump($ical);
        // echo '</pre>';
        // die();

        return $ical;
    }

    public function formatAbonnementTab($id) {
        $abonnementFormat = [];

        $abonnement = new AbonnementICal();

        $abonnements = $abonnement->getAbonnementsByProprietaire($id);

        $server = $_SERVER['HTTP_HOST'];
                
        foreach($abonnements as $key => $abonnement) {
            $abonnementFormat[$key]['id'] = $abonnement['id_abonnement'];

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