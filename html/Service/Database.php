<?php
<<<<<<< HEAD
namespace Service;

use Exception;
use PDO;
use PDOException;
=======
    namespace Service;

use Exception;
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
            }
            catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
>>>>>>> develop

class Database {
    private $pdo;
    private $dsn = 'pgsql:host=servbdd;dbname=pg_ymear;port=5432';
    private $username = 'ymear';
    private $password = 'YOHyohm2929.&';

        public function __construct() {
            try {
                $this->pdo = new PDO($this->dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $this->pdo->exec("set schema 'sae3'");
            }
            catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }

        public function getPDO() {
            return $this->pdo;
        }

    public function executeQuery($query, $params = null) {
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            throw new \Exception('Erreur lors de l\'exécution de la requête : ' . $e->getMessage());
        }
    }

    public function insert($table, $columns, $values) {
        // Ensure $columns and $values are arrays and have the same length
        if (!is_array($columns) || !is_array($values) || count($columns) !== count($values)) {
            throw new Exception('Les colonnes et les valeurs doivent être des tableaux de même longueur.');
        }

        // Prepare column names and placeholders for the query
        $columnsString = implode(', ', $columns);
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        // Create the SQL query
        $query = "INSERT INTO $table ($columnsString) VALUES ($placeholders)";

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }

    //$this->db->update('logement', ['image_principale'], [$fichier], 'id_logement', $idLogement);
    public function update($table, $columns, $values, $whereColumn, $whereValue) {
        // Ensure $columns and $values are arrays and have the same length
        if (!is_array($columns) || !is_array($values) || count($columns) !== count($values)) {
            throw new Exception('Les colonnes et les valeurs doivent être des tableaux de même longueur.');
        }

        // Prepare column names and placeholders for the query
        $set = '';
        for ($i = 0; $i < count($columns); $i++) {
            $set .= $columns[$i] . ' = ?';
            if ($i < count($columns) - 1) {
                $set .= ', ';
            }
        }

        // Create the SQL query
        $query = "UPDATE $table SET $set WHERE $whereColumn = ?";

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute(array_merge($values, [$whereValue]));
        } catch (PDOException $e) {
            throw new Exception('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

}
?>