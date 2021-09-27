<?php
    class RegisterImageRequest {
        public $image_name ;
        public $collection ;
        public $tmp_path ;
        public function __construct ($image_name,$tmp_path,$collection) {
            $this->image_name = $image_name ;
            $this->tmp_path = $tmp_path ;
            $this->collection = $collection ;
        }
    }

    class RegisterImageHandler {

        public $path_images = 'Images/galerie/' ;
        private $_services ;

        public function __construct ($Services) {
            $this->_services = $Services ;
        }

        public function Handle ($request) {
            // Ajouter l'image dans les fichiers du systeme
            $path = $this->path_images . basename($request->image_name) ;
            move_uploaded_file( $request->tmp_path, $path ) ;
            // Ajouter l'image dans la base de donnee
            $this->_services->collectionProvider->addImage(new Image (-1,$path,$request->collection)) ;
        }
    }
?>