<?php

    class DeteImageRequest {
        public $image_id ;
    }

    class DeleteImageHandler {

        private $_services ;

        public function __construct ($Services) {
            $this->_services = $Services ;
        }

        public function Handle ($request) {

            // Supprimer l'image de la base de donnée
            $this->_services->collectionProvider->delImage($request->image_id) ;

            // Supprimer l'image des fichiers du serveur
            $this->clearFileImages() ;

        }

        // Supprimer toutes les images du serveur dont le chemin n'apparait pas 
        // dans la base de donnee
        private function clearFileImages () {
            // Otenir la liste de toutes les images
            $images = $this->_services->collectionProvider->getImages() ;

            // Obtenir la liste de tous les fichiers contenus dans le repertoire des images
            if ($folder = opendir(CollectionProvider::IMAGES_FOLDER)) {
                while (false !== ($file = readdir($folder))) {
                    // Obtenir le chemin relatif vers ces fichiers
                    $path_file = CollectionProvider::IMAGES_FOLDER . $file ;
                    // Si ces fichiers ne sont pas enregistres dans la base de donnee
                    if ($file != '.' && $file != '..' && !$this::isImageRegistered($images,$path_file)) {
                        // Alors supprimer l'image
                        unlink($path_file) ;
                    }
                }
            }
        }

        // Verifier si un fichier <$file_path> fait bien partie de la liste des images enregistrees <$images>
        private static function isImageRegistered ($images,$file_path) {
            foreach ($images as $image) {
                if (($file_path) == $image->path) {
                    return true ;
                }
            }
            return false ;
        }
    }

?>