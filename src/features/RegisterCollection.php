<?php

    class RegisterCollectionRequest {
        public $nom ;
        public function __construct ($nom) {
            $this->nom = $nom ;
        }
    }

    class RegisterCollectionResult {
        public $success ;
        public $collection_id ;
        public function __construc ($success, $collection_id) {
            $this->success = $success ;
            $this->collection_id = $collection_id ;
        }
    }

    class RegisterCollectionHandler {
        private $_services ;
        public function __construct ($Services) {
            $this->_services = $Services ;
        }

        public function Handle ($request) {
            // Enregistrer la collection dans la base de donnees
            $this->_services->collectionProvider->addCollection(new Collection(-1,$request->nom)) ;
            // Obtenir l'id de la derniere collection ajoutee
            $id = $this->_services->collectionProvider->getCollections()[0]->id ;
            return new RegisterCollectionResult(true,$id) ;
        }
    }

?>