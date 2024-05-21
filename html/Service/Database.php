<?php

namespace Service;

use Exception;
use PDO;
use PDOException;

class Database {
    private $pdo;
    private $dsn = 'pgsql:host=servbdd;dbname=pg_cgautieraudi;port=5432';
    private $username = 'cgautieraudi';
    private $password = 'Euchre2566';

    public function __construct() {
        /*try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->pdo->exec("set schema 'sae3'");
        }
        /*
        catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
        */
    }

    public function getPDO() {
        return $this->pdo;
    }

    public function executeQuery($query) {
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $e) {
            throw new \Exception('Erreur lors de l\'exécution de la requête : ' . $e->getMessage());
        }
    }
}
?>