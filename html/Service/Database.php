<?php
namespace Service;

include_once 'Service/Config.php';

use Exception;
use PDO;
use PDOException;

    class Database {
        private $pdo;
        private $dsn = DB_DSN;
        private $username = DB_USERNAME;
        private $password = DB_PASSWORD;

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

    // fonction pour executer une requete à partir d'une chaine de caractère ou d'une requete préparée avec des paramètres
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

    /**
     * permet d'insérer en bdd avec le nom de la table, les colonnes et les valeurs
     */
    public function insert($table, $columns, $values) {
        // verification que les colonnes et les valeurs sont des tableaux et de même longueur
        if (!is_array($columns) || !is_array($values) || count($columns) !== count($values)) {
            throw new Exception('Les colonnes et les valeurs doivent être des tableaux de même longueur.');
        }

        // preparation des colonnes et des placeholders pour la requete
        $columnsString = implode(', ', $columns);
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        // creation de la requet 
        $query = "INSERT INTO $table ($columnsString) VALUES ($placeholders)";

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }

    /**
     * permet de mettre à jour en bdd avec le nom de la table, les colonnes et les valeurs, la colonne de condition et la valeur de condition
     */
    public function update($table, $columns, $values, $whereColumn, $whereValue) {
        // Ensure $columns and $values are arrays and have the same length
        if (!is_array($columns) || !is_array($values) || count($columns) !== count($values)) {
            throw new Exception('Les colonnes et les valeurs doivent être des tableaux de même longueur.');
        }

        // on prepare les colonnes et les placeholders pour la requete
        $set = '';
        for ($i = 0; $i < count($columns); $i++) {
            $set .= $columns[$i] . ' = ?';
            if ($i < count($columns) - 1) {
                $set .= ', ';
            }
        }

        // creation de la requete
        $query = "UPDATE $table SET $set WHERE $whereColumn = ?";

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute(array_merge($values, [$whereValue]));
        } catch (PDOException $e) {
            throw new Exception('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * permet de faire un select en bdd avec le nom de la table, les colonnes, les conditions, l'ordre et la limite
     */
    public function select($table, $columns = ['*'], $conditions = [], $orderBy = null, $limit = null) {
        // Prepare columns
        $columnsString = implode(', ', $columns);

        // on prepare les conditions si elles sont définies
        $where = '';
        $params = [];
        if (!empty($conditions)) {
            $where = ' WHERE ';
            foreach ($conditions as $key => $value) {
                $where .= "$key = ? AND ";
                $params[] = $value;
            }
            $where = rtrim($where, ' AND ');
        }

        // on ajoute l'ordre de tri si il est défini
        $orderByString = '';
        if ($orderBy !== null) {
            $orderByString = " ORDER BY $orderBy";
        }

        // on ajoute la limite si elle est définie
        $limitString = '';
        if ($limit !== null) {
            $limitString = " LIMIT $limit";
        }

       // creation de la requete
        $query = "SELECT $columnsString FROM $table $where $orderByString $limitString";

        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erreur lors de la sélection : ' . $e->getMessage());
        }
    }
}
?>
