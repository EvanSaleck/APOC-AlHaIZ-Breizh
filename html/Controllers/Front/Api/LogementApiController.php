<?php

include 'Service/Database.php';

use Service\Database;


function indexAction()
{
    
    $db = new Database();
    $logements = $db->executeQuery('SELECT * FROM logement');
    
    return $logements;
}