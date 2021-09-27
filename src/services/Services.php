<?php

    include('bdd.php') ;
    include('CollectionProvider.php') ;

    class Services {

        public $bdd ;

        public $collectionProvider ;

        public function __construct () {
            // Importer la base de donnees definie dans bdd.php
            global $bdd ;
            $this->bdd = $bdd ;
            // Initialiser les services
            $this->collectionProvider = new CollectionProvider($this->bdd) ;
        }
    }

    // Définition de la variable
    static $Services ;
    $Services = new Services() ;
?>