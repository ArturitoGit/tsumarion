<?php

    // The path of the directory where images are saved
    $path_images = 'Images/' ;
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
    function registerImage ($bdd , $id_collection , $file_image , $path_images) {
        // Cas de mauvais parametres
        if ($bdd == NULL OR $id_collection == NULL or $file_image == NULL) {
            return ;
        }
        $path = $path_images . basename($file_image['name']) ;
        // Importation de l'image dans le systeme
        move_uploaded_file(
            $file_image['tmp_name'],
            $path);
        // Ajout de l'image dans la bdd
        $req = $bdd->prepare("INSERT INTO images VALUES (NULL, ? , ?)") ;
        $req->execute(array($id_collection,$path)) ;
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
        $req->execute(array($nom_collection)) ;
        // Recherche de l'id ajoute, pour le renvoyer en resultat de la fonction
        $req = $bdd->prepare('SELECT id FROM collections WHERE nom=?') ;
        $req->execute(array($nom_collection)) ;
        $homonymes = $req->fetchAll() ;
        print_r($homonymes) ;
        $len_homonymes = $req->rowCount() ;
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
        $req->execute(array($new_name,$id)) ;
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
        $req->execute(array($id)) ;
        // Suppression de la collection dans sa bdd
        $req = $bdd->prepare("DELETE FROM collections WHERE id=?") ;
        $req->execute(array($id)) ;
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
        $response = $bdd->query("SELECT path FROM images WHERE id=".$id)->fetch();
        if (!$response) {return ;}
        if (file_exists($response['path'])) {
            unlink($response['path']) ;
        }
        // Suppression du fichier dans la base de donnee
        $req = $bdd->prepare("DELETE FROM images WHERE id=?") ;
        $req->execute(array($id)) ;
    }

    function deleteLastImage($bdd, $id_collection) {
        // Recherche de toutes les images de la collection
        $req = $bdd->prepare("SELECT * FROM images WHERE collection=?") ;
        $req->execute(array($id_collection)) ;
        $images = $req->fetchAll();
        $len_images = $req->rowCount() ;
        // Si la collection ne possède pas d'image
        if ($len_images <= 0) {
            return ;
        }
        // Recuperation de l'id de la derniere
        $id_image = $images[$len_images-1]['id'] ;
        // Suppression de l'image
        $bdd->query("DELETE FROM images WHERE id=".$id_image) ;
    }
    

// ---------------------------------------------------------------------------------------------------- */
//      MAIN
// ---------------------------------------------------------------------------------------------------- */

    /* Connexion a la base de donnee */
    $bdd = new PDO('mysql:host=localhost;dbname=tsumarion;charset=utf8', 'root', '');
    if($bdd == NULL) {return;}

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

    /* Requete d'ajout d'image */
    elseif ($action == 'add_image' AND isset($_FILES['file_image']) AND $_FILES['file_image']['error'] == 0
            AND isset($_POST['id_collection'])) {

        // Enregistrer l'image dans la collection
        registerImage($bdd,$_POST['id_collection'],$_FILES['file_image'],$path_images) ;
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

