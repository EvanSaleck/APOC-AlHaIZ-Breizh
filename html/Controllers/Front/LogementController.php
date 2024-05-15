<?php

require 'Service/Database.php';

function indexAction()
{
    $db = new Database();
    $logements = $db->executeQuery('SELECT * FROM logement');

    $logementsJson = json_encode($logements);

    require './Views/Front/logement/index.php';
}