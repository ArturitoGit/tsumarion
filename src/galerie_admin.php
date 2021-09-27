<?php

    // Authentification
    include("global/params.php") ;
    authentificate(4) ;

    // BDD
    include('global/bdd.php') ;

    function getDefaultId($bdd) {
        $response = $bdd->query("SELECT id FROM collections")->fetch_assoc() ;
        if (!$response) {
            // S'il n'y a pas de collections dans la liste -> redirection
            header('Location: accueil.php');
            exit();
        }
        // Sinon retrouner le premier identifiant de la liste
        $id_col = $response['id'] ;
        return $id_col ;
    }

    // Recuperation de l'identifiant de la collection a afficher
    if (isset($_GET['collection']) AND ctype_digit($_GET['collection'])) {
        $id_col = $_GET['collection'] ;
    } else {
        $id_col = getDefaultId($bdd) ;
    }

    // Le nom de la collection
    $req = $bdd->prepare("SELECT nom FROM collections WHERE id=?");
    $req->bind_param('i',$id_col) ;
    $req->execute() ;
    if ($response = $req->get_result()) {
        $nom_col = $response->fetch_array(MYSQLI_ASSOC)['nom'] ;
    } else {
        // Si l'index donne ne correspond a aucune collection
        $nom_col = $bdd->query("SELECT nom FROM collections WHERE id=".getDefaultId($bdd))->fetch()['nom'] ;
        $id_col = getDefaultId($bdd) ;
    }

    // Les images qui la composent
    $sql = "SELECT path,id FROM images WHERE collection=?" ;
    $req = $bdd->prepare($sql) ; 
    $req->bind_param('i',$id_col) ;
    $req->execute() ;
    $result = $req->get_result() ;
    $images = $result->fetch_all(MYSQLI_ASSOC) ;
    $len_images = $result->num_rows ;

    // Les autres collections   
    $sql = "SELECT nom,id FROM collections WHERE id<>?" ;
    $req = $bdd->prepare($sql) ;
    $req->bind_param('i',$id_col) ;
    $req->execute();
    $result = $req->get_result() ;
    $collections = $result->fetch_all(MYSQLI_ASSOC) ;
    $len_collections = $result->num_rows ;        
?>

<!DOCTYPE html>
<html>
<head>

    <!-- Global head -->
    <?php include("global/global_head.html") ?>

    <link rel="stylesheet" href="global/menu.css">
    <link rel="stylesheet" href="galerie/galerie.css">
    <link rel="stylesheet" href="galerie/modal.css">
    <link rel="stylesheet" href="galerie/galerie_admin.css">

    <script src="galerie/modal.js"></script>
    <script src="galerie/galerie_admin.js"></script>

    <title>Galerie Admin</title>

</head>
<body>

<!-- Le menu du site --> 
<?php $active='galerie' ; include('global/menu.php') ?>

<!-- Le contenu de la page -->
<div class="container">

    <!-- Le menu admin -->
    <div class="row" id="control_row">
        <div class="col-md-4"id="form_titre_image">
            <!-- Changer le titre de la collection -->
            <form action="admin.php" method="POST" class="form-inline">
                <div class="form-group">
                    <input type="text"   class="form-control" placeholder="Nouveau titre" id="input_titre" name="nom_collection">
                    <input type="hidden" name="action" value="change_name"/>
                    <input type="hidden" name="id_collection" value="<?=$id_col?>"/> 
                </div>
                <button type="submit" class="btn btn-light">OK</button>
            </form>
        </div>
        <div class="col-md-4" id="admin_image">
            <!-- Ajouter une image a la collection -->
            <form action="admin.php" method="POST" enctype="multipart/form-data" id="form_add_image">
                <input type="file" name="file_images[]" style="display:none ;" id="add_image_link" accept=".jpeg,.jpg,.png" multiple/>
                <input type="button" value="Ajouter image" onClick="onAddImagePressed();" class="btn btn-success btn-lg">
                <input type="hidden" name="action" value="add_image"/> 
                <input type="hidden" name="id_collection" value="<?=$id_col?>"/> 
            </form>
        <!-- Supprimer une image de la collection -->
            <form action="admin.php" method="POST">
                <input type="submit" value="Supprimer image" class="btn btn-danger btn-lg">
                <input type="hidden" name="action" value="delete_image"> 
                <input type="hidden" name="id_collection" value="<?=$id_col?>"> 
            </form>
        </div>
        <div class="col-md-4">
        <!-- Ajouter une nouvelle collection -->
            <form action="admin.php" method="POST">
                <input type="submit" value="Ajouter collection" class="btn btn-success btn-lg">
                <input type="hidden" name="action" value="add_collection"> 
            </form>
        <!-- Supprimer la collection -->
            <form action="admin.php" method="POST" id="delete_col_form">
                <input type="submit" style="display:none;">
                <input type="button" value="Supprimer collection" onClick="onDeleteColPressed();" class="btn btn-danger btn-lg">
                <input type="hidden" name="id_collection" value="<?=$id_col?>"> 
                <input type="hidden" name="action" value="delete_collection"> 
            </form>
        </div>
    </div>

    <!-- Le titre de la collection -->
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9 autres-collections"> 
            <h2><b><?=$nom_col?></b></h2>
        </div>
    </div> 

    <!-- Les images -->
    <div class="row">

        <!-- La colonne des liens vers les autres collections -->
        <div class="col-md-3 autres-collections"> 
            <ul>
                <?php // Boucle sur toutes les collections
                for ($i = 0 ; $i < $len_collections ; $i++) { ?>
                    <li><a href="galerie_admin.php?collection=<?=$collections[$i]['id']?>"><?=$collections[$i]['nom']?></a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- Les 3 colonnes d'images -->
        <?php // Boucle sur les 3 colonnes 
        for ($colonne = 0 ; $colonne < 3 ; $colonne ++) { ?>
            <div class="col-md-3">
            <?php // Dans une colonne on affiche une image sur 3 en partant d'un offset $colonne
            $i = $colonne ; 
            while ($i < $len_images) { 
                $id_image = $images[$i]['id'] ;
                $path_image = $images[$i]['path'] ;?>
                <!-- Une colonne d'images -->
                <div class="vignette">
                    <img src="<?=$path_image?>" onclick="openModal();currentSlide(<?=$i+1?>)">
                    <form method="post" action="admin.php" id="delete_image_post_<?=$id_image?>">
                        <input type="hidden" name="action" value="delete_image">
                        <input type="hidden" name="id_collection" value="<?=$id_col?>">
                        <input type="hidden" name="id_image" value="<?=$id_image?>">
                    </form>
                    <!-- Bouton de suppression de l'image -->
                    <button class="del_image_btn" onClick="onDeleteImagePressed(<?=$id_image?>);">X</button>
                </div>
                <?php $i += 3 ; 
            } ?>
            </div>
        <?php } ?>
        
</div>

</body>
</html>