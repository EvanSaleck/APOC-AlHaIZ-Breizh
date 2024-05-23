<?php
    namespace Controllers\Front;

    include_once 'Models/Utilisateur.php';

    use Models\Utilisateur;


    class UtilisateurController {

        private $user;

        public function __construct() {
            $this->user = new Utilisateur();
        }

        public function getCompteClientDetails($idCompte) {
            
            $dataCompteClient = $this->user->getCompteClientDetails($idCompte);
        
            header('Content-Type: application/json');
            echo json_encode($dataCompteClient);
        }

        public function connexionClient($data) {
            try {
                $utilisateur = new Utilisateur();
                $return = $utilisateur->connexionClient($data);

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
                $utilisateur = new Utilisateur();
                $return = $utilisateur->inscriptionClient($data);

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
                $utilisateur = new Utilisateur();
                $return = $utilisateur->connexionProprio($data);

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
                $utilisateur = new Utilisateur();
                $return = $utilisateur->inscriptionProprio($data);

                header('Content-Type: application/json');
                echo json_encode($return);
            }
            catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['Erreur : ' => $e->getMessage()]);
                exit;
            }
        }
    }