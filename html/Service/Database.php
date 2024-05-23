<?php
    namespace Service;

    require_once 'Config.php';
    use const DB_DSN;
    use const DB_USERNAME;
    use const DB_PASSWORD;

    use Exception;
    use PDO;
    use PDOException;

    class Database {
        private $pdo;

        public function __construct() {
            try {
                $this->pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
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