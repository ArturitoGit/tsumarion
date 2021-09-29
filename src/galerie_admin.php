<?php
    // Authentification
    include("global/params.php") ;
    authentificate(4) ;

    // Recuperer les parametres de la requete GET
    $id_col = null ;
    if (isset($_GET['collection'])) {
        $id_col = intval($_GET['collection']) ;
    }

    // Appel de la fonctionnalite InitGallery
    require_once "services/Services.php" ;
    require_once "features/InitGallery.php" ;
    $request = new InitGalleryRequest($id_col) ;
    $result = (new InitGalleryHandler($Services))->Handle($request) ;        
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
                    <input type="hidden" name="id_collection" value="<?=$result->collection->id?>"/> 
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
                <input type="hidden" name="id_collection" value="<?=$result->collection->id?>"/> 
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
                <input type="hidden" name="id_collection" value="<?=$result->collection->id?>"> 
                <input type="hidden" name="action" value="delete_collection"> 
            </form>
        </div>
    </div>

    <!-- Le titre de la collection -->
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9 autres-collections"> 
            <h2><b><?=$result->collection->nom?></b></h2>
        </div>
    </div> 

    <!-- Les images -->
    <div class="row">

        <!-- La colonne des liens vers les autres collections -->
        <div class="col-md-3 autres-collections"> 
            <ul>
                <?php // Boucle sur toutes les collections
                for ($i = 0 ; $i < count($result->all_collections) ; $i++) {
                    $i_collection = $result->all_collections[$i] ;
                    // Permet d'ajouter l'id "active" sur le lien de la collection courante
                    $id_active = ($i_collection->id == $result->collection->id) ? "id='active'" : "" ;?>
                    <li>
                        <a href="galerie_admin.php?collection=<?=$i_collection->id?>"<?=$id_active?>><?=$i_collection->nom?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <!-- Les 3 colonnes d'images -->
        <?php // Boucle sur les 3 colonnes 
        for ($colonne = 0 ; $colonne < 3 ; $colonne ++) { ?>
            <div class="col-md-3">
            <?php // Dans une colonne on affiche une image sur 3 en partant d'un offset $colonne
                $i = $colonne ; 
                while ($i < count($result->images)) { ?>
                    <!-- Une colonne d'images -->
                    <div class="vignette">
                        <img src="<?=$result->images[$i]->path?>"  onclick="openModal();currentSlide(<?=$i+1?>)">
                        <form method="post" action="admin.php" id="delete_image_post_<?=$result->images[$i]->id?>">
                            <input type="hidden" name="action" value="delete_image">
                            <input type="hidden" name="id_collection" value="<?=$result->collection->id?>">
                            <input type="hidden" name="id_image" value="<?=$result->images[$i]->id?>">
                        </form>
                        <!-- Bouton de suppression de l'image -->
                        <button class="del_image_btn" onClick="onDeleteImagePressed(<?=$result->images[$i]->id?>);">X</button>
                    </div>
                    <?php $i += 3 ; 
                } ?>
            </div>
        <?php } ?>
        
</div>

</body>
</html>