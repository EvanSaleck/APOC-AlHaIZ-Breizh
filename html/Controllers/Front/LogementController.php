<?php

require 'Service/Database.php';

use Service\Database;

function indexAction()
{
    $db = new Database();
    $logements = $db->executeQuery('SELECT * FROM logement');

    $logementsJson = json_encode($logements);

    // $user = 'Lucas';

    require './Views/Front/logement/index.php';
}