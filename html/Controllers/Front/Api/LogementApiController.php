<?php

function indexAction()
{
    $db = new Database();
    $logements = $db->executeQuery('SELECT * FROM logement');
    
    return json_encode($logements);
}