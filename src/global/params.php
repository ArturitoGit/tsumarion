<?php

    // Le chemin vers la base du projet
    $root_path = "/var/www/tsumarion/" ;

    // Le chemin vers le repertoire d'images (images de l'ecran d'accueil ou icones par exemple)
    $images_path = $root_path . "Images/" ;

    // Le chemin  vers le repertoire d'images de la galerie
    $galery_image_path = $images_path . "galerie/" ;

    // La liste des adresses de toutes les pages du site web
    $pages = array(
        "accueil.php",          // 0
        "galerie.php",          // 1
        "boutique.php",         // 2
        "contact.php",          // 3
        "galerie_admin.php"     // 4
    );
    $nb_pages = count($pages) ;

    // A utiliser au debut d'une page, cette fonction permet de 
    // rediriger l'utilisateur vers une page de connexion dans le cas ou
    // il n'est pas deja connecte
    //
    // Parametre :
    //      cible : Index de la page qui appelle le service d'authentification, utile pour la 
    //              redirection une fois l'authentification effectuee
    function authentificate ($cible) {
        // Recuperer les informations de session
        session_start() ;
        // Rediriger vers la page de login si non connectes
        if (!isset($_SESSION['connected']) OR !$_SESSION['connected']) {
            header('Location: login.php?cible=' . $cible) ;
            exit() ;
        }
    }

?>