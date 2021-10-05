<?php

    // Cette classe permet d'obtenir les donnees necessaires a l'affichage de la galerie
    //
    // Elle prend en parametre l'id de la galerie a charger, et retourne :
    //      - Une variable booleenne qui indique si la requete a reussi ou echoue
    //      - La liste de toutes les collections disponibles
    //      - La collection concernee
    //      - La liste des images de cette collection
    //
    // Cette classe gère aussi le cas ou l'identifiant donne en parametre est null ou n'existe pas :
    // Les informations retournees seront alors celles de la premiere collection trouvee

    class InitGalleryRequest {
        public $id_col ;
        public function __construct ($id_col) {
            $this->id_col = $id_col ;
        }
    }

    class InitGalleryResult {
        public $success ;
        public $all_collections ;
        public $collection ;
        public $images ;
        public function __construct($success,$all_collections,$collection,$images) {
            $this->success = $success ;
            $this->collection = $collection ;
            $this->all_collections = $all_collections ;
            $this->images = $images ;
        }
    }

    class InitGalleryHandler {

        private $_services ;
        public function __construct ($services) {
            $this->_services = $services ;
        }

        public function Handle ($request) {

            // Recuperer toutes les collections
            $all_collections = $this->_services->collectionProvider->getCollections() ;
            // Si il n'existe aucune collection alors echec de la requete
            if (count($all_collections) <= 0) {
                return new InitGalleryResult(false,null,null,null) ;
            }

            // Recherche de l'identifiant de la collection dans la base de donnees
            $collection = $this->_services->collectionProvider->getCollection($request->id_col) ;

            // Si l'identifiant est null ou n'existe pas dans la base de donnees, on prend une collection par defaut
            if ($collection == null) {
                // Recuperer la premiere collection disponible
                $collection = $all_collections[0] ;
            }

            // Recuperer les images de la collection
            $images = $this->_services->collectionProvider->getImagesOfCol($collection->id) ;

            return new InitGalleryResult(true,$all_collections,$collection,$images) ;
        }
    }
?>