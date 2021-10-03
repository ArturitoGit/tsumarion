<?php

    require_once('CollectionProvider.php') ;
    require_once('AdminProvider.php') ;

    class Services {

        // La base de donnees
        public $bdd ;

        // Les services a proposer a tout le site web
        public $collectionProvider ;
        public $adminProvider ;

        public function __construct () {
            require_once('bdd.php') ;
            // Importer la base de donnees definie dans bdd.php
            global $bdd ;
            $this->bdd = $bdd ;
            // Initialiser les services
            $this->collectionProvider = new CollectionProvider($this->bdd) ;
            $this->adminProvider = new AdminProvider($this->bdd) ;
        }
    }

    class FakeServices {
        // Les services a proposer a tout le site web
        public $collectionProvider ;
        public $adminProvider ;

        public function __construct () {
            // Initialiser les services
            $this->collectionProvider = new FakeCollectionProvider() ;
            $this->adminProvider = new FakeAdminProvider() ;
        }  
    }

    // Définition de la variable
    static $Services ;
    //$Services = new Services() ;
    $Services = new FakeServices() ;
?>