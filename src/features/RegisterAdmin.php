<?php

    class RegisterAdminRequest {
        public $pseudo ;
        public $pwd ;
        public function __construct ($pseudo,$pwd) {
            $this->pseudo = $pseudo ;
            $this->pwd = $pwd ;
        }
    }

    class RegisterAdminResult {
        public $success ;
        public function __construct ($success) {
            $this->success = $success ;
        }
    }

    class RegisterAdminHandler {
        private $_services ;
        public function __construct ($Services) {
            $this->_services = $Services ;
        }

        public function Handle ($request) {

            // Crypter le mot de passe de l'utilisateur pour ne pas le mettre en clair dans la bdd
            require_once 'Login.php' ;
            $crypted_pwd = Login::crypt_pwd($request->pseudo,$request->pwd) ;
            // Ajouter les informations dans la bdd
            $this->_services->adminProvider->AddAdmin(new Admin (
                -1,$request->pseudo, $crypted_pwd )) ;
            
            return new RegisterAdminResult(true) ;
        }
    }

?>