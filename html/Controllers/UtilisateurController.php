<?php
    namespace Controllers;

    include_once 'Models/Utilisateur.php';

    use Models\Utilisateur;
    use \Exception;

    class UtilisateurController {

        private $user;

        public function __construct(){
            $this->user = new Utilisateur();
        }

        /**
         * Récupère les détails d'un compte client
         */
        public function getCompteClientDetails($idCompte) {
            
            $dataCompteClient = $this->user->getCompteClientDetails($idCompte);
        
            header('Content-Type: application/json');
            echo json_encode($dataCompteClient);
        }

        /**
         * connexion d'un client
         */
        public function connexionClient($data) {
            try {
                $return = $this->user->connexionClient($data);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
                exit;
            }
        }

        /**
         *  Inscription d'un client
         */
        public function inscriptionClient($data) {
            try {
                $return = $this->user->inscriptionClient($data);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['Erreur : ' => $e->getMessage()]);
                exit;
            }
        }

        /**
         * connexion d'un propriétaire
         */
        public function connexionProprio($data) {
            try {
                $return = $this->user->connexionProprio($data);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
                exit;
            }
        }

        /**
         * Inscription d'un propriétaire
         */
        public function inscriptionProprio($data) {
            try {
                $return = $this->user->inscriptionProprio($data);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['Erreur : ' => $e->getMessage()]);
                exit;
            }
        }

        /**
         * Récupère les détails d'un compte propriétaire par son id
         */
        public function getProprioById($id) {
            try {
                $utilisateur = new Utilisateur();
                $return = $utilisateur->getProprioById($id);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
                exit;
            }
        }

        /**
         * Récupère les détails d'un compte propriétaire par son id 
         */
        public function getCompteProprioDetails($id){
            try {
                $dataCompteProprio = $this->user->getCompteProprietaireDetails($id);
        
                header('Content-Type: application/json');
                echo json_encode($dataCompteProprio);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
                exit;
            }
        }

        /**
         * Récupère tous les tokens d'un propriétaire avec son id
         */
        public function getAllTokenById($id){
            try {
                $return = $this->user->getAllTokenById($id);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
                exit;
            }
        }

        /**
         * Supprime un token d'un propriétaire
         */
        public function deleteToken($values){
            try {
                $cle = $values['id_cle'];
                $idproprio = $values['id_proprio'];
                $return = $this->user->deleteToken($cle, $idproprio);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
                exit;
            }
        }
        
        /**
         * génère un token pour un propriétaire
         */
        public function generateToken($values){
            try {
                $return = $this->user->generateToken($values['id_proprio']);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
            }
        }

        /**
         * met à jour le mot de passe d'un utilisateur
         */
        public function updatePassword($values){
            try {
                $mdp = $values['oldPwd'];
                $newmdp = $values['newPwd'];
                $confmdp = $values['confPwd'];
                $id = $values['id'];


                $return = $this->user->updatePassword($mdp, $newmdp, $confmdp, $id);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
            }
        }

        /**
         * met à jour le mot de passe d'un client
         */
        public function updateCliPassword($values){
            try {
                $mdp = $values['oldPwd'];
                $newmdp = $values['newPwd'];
                $confmdp = $values['confPwd'];
                $id = $values['id'];

                $return = $this->user->updateCliPassword($mdp, $newmdp, $confmdp, $id);

                header('Content-Type: application/json');
                echo json_encode($return);    
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
            }            
        }

        /**
         * met à jour le profil d'un utilisateur
         */
        public function updateProfile($values){
            try {
                $return = $this->user->updateProfile($values);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
            }
        }

        /**
         * met à jour le profil d'un client
         */
        public function updateCliProfile($values){
            try {
                $return = $this->user->updateCliProfile($values);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
            }
        }
    }