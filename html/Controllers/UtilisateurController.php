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

        public function getCompteClientDetails($idCompte) {
            
            $dataCompteClient = $this->user->getCompteClientDetails($idCompte);
        
            header('Content-Type: application/json');
            echo json_encode($dataCompteClient);
        }

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

        public function connexionProprietaire($data) {
            try {
                $return = $this->user->connexionProprietaire($data);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode($e->getMessage());
                exit;
            }
        }

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
        public function inscriptionProprietaire($data) {
            try {
                $return = $this->user->inscriptionProprietaire($data);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['Erreur : ' => $e->getMessage()]);
                exit;
            }
        }

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