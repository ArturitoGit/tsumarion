<?php

    class Admin {
        public $id ;
        public $pseudo ;
        public $pwd ;
        public function __construct ($id,$pseudo, $pwd) {
            $this->id = $id ;
            $this->pseudo = $pseudo ;
            $this->pwd = $pwd ;
        }
    }

    interface IAdminProvider {

        // Obtenir tous les admins existants
        public function getAdmins() ;

        // Obtenir un admin avec son pseudo
        public function getAdmin($pseudo) ;

        // Ajouter un admin
        public function addAdmin($admin) ;

        // Supprimer un admin
        public function delAdmin($id) ;

        // Mettre a jour un admin
        public function updateAdmin($id,$admin) ;
    }

    class AdminProvider implements IAdminProvider {

        private $_bdd ;
        public function __construct ($bdd) {
            $this->_bdd = $bdd ;
        }

        public function getAdmins() {
            $sql = "SELECT * FROM admin ORDER BY id ASC" ;
            $result = $this->_bdd->query($sql) ;
            return $this->resultToArray($result) ;
        }

        public function getAdmin ($pseudo) {
            $sql = "SELECT * FROM admin WHERE pseudo=?" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('s',$pseudo) ;
            $req->execute() ;
            $result = $req->get_result() ;
            return $result->fetch_object() ;
        }

        public function addAdmin($admin) {
            $sql = "INSERT INTO admin VALUES (NULL, ? , ?)" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('ss',$admin->pseudo,$admin->pwd) ;
            $req->execute() ;
        }

        public function delAdmin($id) {
            $sql = "DELETE FROM admin WHERE id=?" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('i', $id ) ;
            $req->execute() ;
        }

        public function updateAdmin($id,$admin) {
            $sql = "UPDATE admin SET pseudo=?, pwd=? WHERE id=?" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('si',$admin->pseudo,$admin->pwd,$admin->id) ;
            $req->execute() ;
        }

    }

?>