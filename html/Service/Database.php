<?php

namespace Service;


use PDO;
use PDOException;

class Database {
    private $pdo;
    private $dsn = 'pgsql:host=localhost;dbname=apoc;port=5432';
    private $username = 'apoc';
    private $password = 'apoc';

    public function __construct() {
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->pdo->exec("set schema 'sae3'");
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
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
        } catch (PDOException $e) {
            die('Erreur lors de l\'exécution de la requête : ' . $e->getMessage());
        }
    }
}
?>