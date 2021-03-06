<?php

    // L'objet collection contient seulement un nom
    class Collection {
        public $id ;
        public $nom ; 
        public function __construct ($id,$nom) {
            $this->id = $id ;
            $this->nom = $nom ;
        }
    }

    // L'object Image contient un chemin et une reference vers une collection
    class Image {
        public $id ;
        public $path ;
        public $collection ;
        public function __construct ($id,$path,$collection_id) {
            $this->id = $id ;
            $this->path = $path ;
            $this->collection = $collection_id ;
        }
    }

    // Les methodes qui permettent d'interagir avec les collections et leurs images
    interface ICollectionProvider {

        // Obtenir toutes les collections existantes
        public function getCollections() ;

        // Ajouter une collection
        public function addCollection($col) ;

        // Supprimer une collection
        public function delCollection($id) ;

        // Mettre a jour une collection
        public function updateCollection($id,$col) ;

        // Obtenir une collection
        public function getCollection($id) ;

        // Obtenir les images d'une collection
        public function getImagesOfCol($id_col) ;

        // Ajouter une image a la collection
        public function addImage($image) ;

        // Supprimer une image de la collection
        public function delImage($id_image) ;

        // Obtenir toutes les images enregistrees
        public function getImages() ;

    }

    // Implementation de l'interface ICollectionProvider pour une base de donnee mysqli
    class CollectionProvider implements ICollectionProvider {

        // Le chemin du dossier qui contient les images des collections
        public const IMAGES_FOLDER = 'Images/galerie/' ;

        private $_bdd ;
        public function __construct ($bdd) {
            $this->_bdd = $bdd ;
        }

        public function getCollections() {
            $sql = "SELECT * FROM collections ORDER BY id ASC" ;
            $result = $this->_bdd->query($sql) ;
            return $this->resultToArray($result) ;
        }

        public function addCollection($col) {
            $sql = "INSERT INTO collections VALUES (NULL , ?)" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('s', $col->nom ) ;
            $req->execute() ;
        }

        public function delCollection($id) {
            $sql = "DELETE FROM collections WHERE id=?" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('i', $id ) ;
            $req->execute() ;
        }

        public function updateCollection($id,$col) {
            $sql = "UPDATE collections SET nom=? WHERE id=?" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('si',$col->nom,$id) ;
            $req->execute() ;
        }

        public function getCollection($id) {
            $sql = "SELECT * FROM collections WHERE id=?" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('i',$id) ;
            $req->execute() ;
            $result = $req->get_result() ;
            return $result->fetch_object() ;
        }

        public function getImagesOfCol($id_col) {
            $sql = "SELECT * FROM images WHERE collection=? ORDER BY id DESC" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('i',$id_col) ;
            $req->execute() ;
            $result = $req->get_result() ;
            return $this->resultToArray($result) ;
        }

        public function addImage($image) {
            $sql = "INSERT INTO images VALUES (NULL, ? , ?)" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('is',$image->collection,$image->path) ;
            $req->execute() ;
        }

        public function delImage($id_image) {
            $sql = "DELETE FROM images WHERE id=?" ;
            $req = $this->_bdd->prepare($sql) ;
            $req->bind_param('i',$id_image) ;
            $req->execute() ;  
        }

        public function getImages () {
            $sql = "SELECT * FROM images ORDER BY id DESC" ;
            $result = $this->_bdd->query($sql) ;
            return $this->resultToArray($result) ;
        }

        // Transformer un resultat de requete MYSQLI en tableau d'objets
        private function resultToArray ($result) {
            if ($result->num_rows == 0) {
                return array() ;
            }
            $res = array($result->num_rows) ;
            $index = $result->num_rows ;
            while($obj = $result->fetch_object()) {
                $index -- ;
                $res[$index] = $obj ;
            }
            return $res ;
        }
    }

    class FakeCollectionProvider implements ICollectionProvider {
        // Obtenir toutes les collections existantes
        public function getCollections() {
            return array (
                new Collection(1,"Collection 1"),
                new Collection(2,"Collection 20")
            );
        }

        // Ajouter une collection
        public function addCollection($col) {}

        // Supprimer une collection
        public function delCollection($id) {}

        // Mettre a jour une collection
        public function updateCollection($id,$col) {}

        // Obtenir une collection
        public function getCollection($id) {
            return (new Collection(2,"Collection 2"));
        }

        // Obtenir les images d'une collection
        public function getImagesOfCol($id_col) {
            return array() ;
        }

        // Ajouter une image a la collection
        public function addImage($image) {}

        // Supprimer une image de la collection
        public function delImage($id_image) {}

        public function getImages() {}
    }
?>