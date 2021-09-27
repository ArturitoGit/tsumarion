<?php 

    class LoginRequest {
        public $pseudo ;
        public $pwd ;
        public function __construct ($pseudo,$pwd) {
            $this->pseudo = $pseudo ;
            $this->pwd = $pwd ;
        }
    }

    class LoginResult {
        public $success ;
        public $id ;
        public function __construct ($success,$id) {
            $this->success = $success ;
            $this->id = $id ;
        }
    }

    class LoginHandler {

        public const SALT = "@|-°+==04601doQ" ;

        private $_services ;
        public function __construct ($Services) {
            $this->_services = $Services ;
        }

        public function Handle ($request) {
            // Rechercher l'admin en fonction de son pseudo
            $admin = $this->_services->adminProvider->getAdmin($request->pseudo) ;
            // Si le mot de passe correspond :
            if ($admin != null AND 
                $admin->pwd == self::crypt_pwd($request->pseudo,$request->pwd)) {
                // Alors retourner l'id de l'admin
                return new LoginResult(true,$admin->id);
            }
            // Sinon retourner un echec de connexion
            return new LoginResult(false,null) ;
        }


        public static function crypt_pwd ($pseudo,$pwd) {
            return $pwd ;
        }

        public static function crypt_pwd_salt ($pseudo,$pwd) {
            return md5( self::SALT . $pseudo . self::SALT . $pwd . self::SALT ) ;
        }
    }

?>