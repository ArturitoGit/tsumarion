<?php

    // The path of the directory where images are saved
    $path_images = 'Images/galerie/' ;
    // The default name of the new collections
    $new_col_default_name = "Nouvelle_collection" ;

/* ---------------------------------------------------------------------------------------------------- */
//      FUNCTIONS
/* ---------------------------------------------------------------------------------------------------- */
    /**
     * Register a new image on the given collection
     * $bdd             : the database to update
     * $id_collection   : the id of the collection
     * $file_image      : the image to be added
     */
    function registerImage ($bdd , $id_collection , $image_name, $image_tmp_name , $path_images) {
        // Cas de mauvais parametres
        if ($bdd == NULL OR $id_collection == NULL) {
            return ;
        }
        $path = $path_images . basename($image_name) ;
        // Importation de l'image dans le systeme
        move_uploaded_file(
            $image_tmp_name,
            $path);
        // Ajout de l'image dans la bdd
        $req = $bdd->prepare("INSERT INTO images VALUES (NULL, ? , ?)") ;
        $req->bind_param('ss',$id_collection,$path) ;
        $req->execute() ;
    }

    /**
     * Register a new collection
     * $bdd             : the database to update
     * $nom_collection  : the name of the collection to be registered
     * RETURN : the id of the generated collection
     */
    function registerCollection($bdd , $nom_collection) {
        // Cas de mauvais parametres
        if ($bdd == NULL OR $nom_collection == NULL) {
            return ;
        }
        // Ajout de la collection dans la bdd
        $sql = "INSERT INTO collections VALUES (NULL , ?)" ;
        $req = $bdd->prepare($sql) ;
        $req->bind_param('s',$nom_collection) ;
        $req->execute() ;
        // Recherche de l'id ajoute, pour le renvoyer en resultat de la fonction
        $req = $bdd->prepare('SELECT id FROM collections WHERE nom=?') ;
        $req->bind_param('s',$nom_collection) ;
        $req->execute() ;
        $result = $req->get_result() ;
        $homonymes = $result->fetch_all(MYSQLI_ASSOC) ;
        $len_homonymes = $result->num_rows ;
        return ($homonymes[$len_homonymes - 1]['id']) ;
    }

    /**
     * Change the name of a given collection in the bdd
     * $bdd         : the database to update
     * $id          : the id of the collection to update
     * $new_name    : the new name to give to this collection
     */
    function setCollectionName($bdd, $id, $new_name) {
        // Cas de mauvais parametres
        if ($bdd == NULL OR $id == NULL or $new_name == NULL) {
            return ;
        }
        // Changement du nom dans la bdd
        $req = $bdd->prepare("UPDATE collections SET nom=? WHERE id=?") ;
        $req->bind_param('si',$new_name,$id) ;
        $req->execute() ;
    }

    /**
     * Delete a collection and all its images from the database
     * $bdd : the database to update
     * $id  : the id of the collection to delete
     */
    function deleteCollection($bdd, $id) {
        // Cas de mauvais parametres
        if ($bdd == NULL OR $id == NULL) {
            return ;
        }
        // Suppression de toutes les images de la collection
        $req = $bdd->prepare("DELETE FROM images WHERE collection=?") ;
        $req->bind_param('i',$id) ;
        $req->execute() ;
        // Suppression de la collection dans sa bdd
        $req = $bdd->prepare("DELETE FROM collections WHERE id=?") ;
        $req->bind_param('i',$id) ;
        $req->execute() ;
    }

    /**
     * Delete an image from the dbb and the server files
     * $bdd : the database to update
     * $id  : the id of the image to delete
     */
    function deleteImage($bdd, $id) {
        // Cas de mauvais parametres
        if ($bdd == NULL OR $id == NULL) {
            return ;
        }
        // Suppression du fichier dans le systeme
        $req = $bdd->prepare("DELETE FROM images WHERE id=?") ;
        $req->bind_param('i',$id) ;
        $req->execute() ;
    }

    function deleteLastImage($bdd, $id_collection) {
        // Recherche de toutes les images de la collection
        $req = $bdd->prepare("SELECT * FROM images WHERE collection=?") ;
        $req->bind_param('i',$id_collection) ;
        $req->execute() ;
        $result = $req->get_result() ;
        $images = $result->fetch_all(MYSQLI_ASSOC);
        $len_images = $result->num_rows ;
        // Si la collection ne possède pas d'image
        if ($len_images <= 0) {
            return ;
        }
        // Recuperation de l'id de la derniere
        $id_image = $images[$len_images-1]['id'] ;
        // Suppression de l'image
        $bdd->query("DELETE FROM images WHERE id=".$id_image) ;
        // Suppression de l'image du repertoire
        // ?
    }
    

// ---------------------------------------------------------------------------------------------------- */
//      MAIN
// ---------------------------------------------------------------------------------------------------- */

    /* Connexion a la base de donnee */
    include('global/bdd.php') ;

    /* Recuperation du parametre action */
    $action = NULL ;
    if (isset($_POST['action'])) {
        $action = $_POST['action'] ;
    }

    /* Requete de suppression d'une collection */
    if ($action == 'delete_collection' AND isset($_POST['id_collection'])) {
        deleteCollection($bdd,$_POST['id_collection']) ;
        // Redirection vers la page admin defaut
        header ('Location: galerie_admin.php') ;
        exit() ;
    }

    /* Requete de suppression d'une image */
    elseif ($action == 'delete_image' AND isset($_POST['id_image']) AND isset($_POST['id_collection'])) {
        deleteImage($bdd,$_POST['id_image']) ;
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
        setCollectionName($bdd,$_POST['id_collection'],$_POST['nom_collection']) ;
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
                // Alors enregistrer cette image
                registerImage($bdd,
                    $_POST['id_collection'],
                    $_FILES['file_images']['name'][$i],
                    $_FILES['file_images']['tmp_name'][$i],
                    $path_images) ;
            }
        }
        // Redirection vers la page admin de cette collection
        header ('Location: galerie_admin.php?collection='.$_POST['id_collection']) ;
        exit() ;
    }

    /* Requete d'ajout de collection */
    elseif ($action == 'add_collection') {
        $id_col = registerCollection($bdd,$new_col_default_name) ;
        // Redirection vers la page admin de cette collection
        header ('Location: galerie_admin.php?collection='.$id_col) ;
        exit() ;
    }

/* ---------------------------------------------------------------------------------------------------- */
?>

