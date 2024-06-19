<?php 

namespace Service;

include_once 'Models/Reservation.php';

use Models\Reservation;

class ICalService {

    private $reservationModel;

    public function __construct() {
        $this->reservationModel = new Reservation();
    }

    // export iCal with url and token
    public function exportIcal($form) {
        $dateDebut = $form['dateDebut'];
        $dateFin = $form['dateFin'];
        $logements = $form['logements'];
        
        $reservations = $this->reservationModel->getReservationsForExportICal($dateDebut, $dateFin, $logements);

        $reservationICal =  $this->getReservationsIcal($reservations);

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="reservations.ics"');
        echo $reservationICal;
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
            $ical .= "DTSTART:" . $reservation['date_arrivee'] . "\n";
            $ical .= "DTEND:" . $reservation['date_depart'] . "\n";
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
}