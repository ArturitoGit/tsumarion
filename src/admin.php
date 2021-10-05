<?php
    

// ---------------------------------------------------------------------------------------------------- */
//      MAIN
// ---------------------------------------------------------------------------------------------------- */

    require_once 'services/Services.php' ;
    require_once 'features/RegisterCollection.php' ;
    require_once 'features/RegisterImage.php' ;
    require_once 'features/DeleteImage.php' ;   

    /* Recuperation du parametre action */
    $action = NULL ;
    if (isset($_POST['action'])) {
        $action = $_POST['action'] ;
    }

    /* Requete de suppression d'une collection */
    if ($action == 'delete_collection' AND isset($_POST['id_collection'])) {
        $Services->collectionProvider->delCollection(intval($_POST['id_collection'])) ;
        // Redirection vers la page admin defaut
        header ('Location: galerie_admin.php') ;
        exit() ;
    }

    /* Requete de suppression d'une image */
    elseif ($action == 'delete_image' AND isset($_POST['id_image']) AND isset($_POST['id_collection'])) {
        // $Services->collectionProvider->delImage(intval($_POST['id_image'])) ;
        $request = new DeleteImageRequest(intval($_POST['id_image'])) ;
        (new DeleteImageHandler ($Services))->Handle($request) ;
        // Redirection vers la page admin de cette collection
        header ('Location: galerie_admin.php?collection='.$_POST['id_collection']) ;
        exit() ;
    }

    /* Requete de suppression de la derniere image */
    elseif ($action == 'delete_image' AND isset($_POST['id_collection'])) {
        deleteLastImage($bdd,$_POST['id_collection']) ;
        // Redirection vers la page admin de cette collection
        header ('Location: galerie_admin.php?collection='.$_POST['id_collection']) ;
        exit() ;
    }

    /* Requete de changement de nom d'une collection */
    elseif ($action == 'change_name' AND isset($_POST['nom_collection']) AND isset($_POST['id_collection'])) {
        $Services->collectionProvider->updateCollection(intval($_POST['id_collection']),new Collection (-1,$_POST['nom_collection'])) ;
        // Redirection vers la page admin de cette collection
        header ('Location: galerie_admin.php?collection='.$_POST['id_collection']) ;
        exit() ;
    }

    elseif ($action == 'add_image' AND isset($_FILES['file_images']) AND isset($_POST['id_collection'])) {
        // Trouver le nombre d'images
        $countfiles = count($_FILES['file_images']['name']);
        // Parcourir toutes les images
        for ($i=0 ; $i<$countfiles ; $i++) {
            // Si l'image a ete telechargee sans erreur
            if ($_FILES['file_images']['error'][$i] == 0) {
                $request = new RegisterImageRequest(
                    $_FILES['file_images']['name'][$i],
                    $_FILES['file_images']['tmp_name'][$i],
                    intval($_POST['id_collection'])) ;
                (new RegisterImageHandler($Services))->Handle($request) ;
            }
        }
        // Redirection vers la page admin de cette collection
        header ('Location: galerie_admin.php?collection='.$_POST['id_collection']) ;
        exit() ;
    }

    /* Requete d'ajout de collection */
    elseif ($action == 'add_collection') {
        $request = new RegisterCollectionRequest("Nouvelle collection") ;
        $result = (new RegisterCollectionHandler($Services))->Handle($request) ;
        // Redirection vers la page admin de cette collection
        header ('Location: galerie_admin.php?collection='.$result->collection_id) ;
        exit() ;
    }

/* ---------------------------------------------------------------------------------------------------- */
?>

