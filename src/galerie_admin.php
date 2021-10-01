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
    <link rel="stylesheet" href="global/head.css">
    <link rel="stylesheet" href="galerie/galerie.css">
    <link rel="stylesheet" href="galerie/galerie_admin.css">
    <link rel="stylesheet" href="galerie/modal.css">
    <script src="galerie/modal.js"></script>
    <script src="galerie/galerie_admin.js"></script>

    <title>Galerie Admin</title>

</head>
<body>

<!-- Le menu du site --> 
<?php $page='Galerie' ; include('global/head.php') ?>

<!-- Le menu admin -->
<div id="menu-admin">
    <!-- Changer le titre de la collection -->
    <form action="admin.php" method="POST" class="form-inline" id="form_change_name">
        <div class="form-group">
            <input type="text"   class="form-control" placeholder="Nouveau titre" id="input_titre" name="nom_collection">
            <input type="hidden" name="action" value="change_name"/>
            <input type="hidden" name="id_collection" value="<?=$result->collection->id?>"/> 
        </div>
        <button type="submit" class="btn btn-light">OK</button>
    </form>
    <!-- Ajouter une image a la collection -->
    <form action="admin.php" method="POST" enctype="multipart/form-data" id="form_add_image">
        <input type="file" name="file_images[]" style="display:none ;" id="add_image_link" accept=".jpeg,.jpg,.png" multiple/>
        <input type="button" value="Ajouter image" onClick="onAddImagePressed();" class="btn btn-success btn-lg">
        <input type="hidden" name="action" value="add_image"/> 
        <input type="hidden" name="id_collection" value="<?=$result->collection->id?>"/> 
    </form>
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

<div id="galerie-page">
    <!-- La colonne des autres collections -->
    <div id="autres-collections">
        <h3>Autres collections</h3>
        <?php for ($i = 0 ; $i < count($result->all_collections) ; $i ++) {  
                    $collection = $result->all_collections[$i] ;
                    $activeId = $collection->id == $result->collection->id ? 'id="active-collection"':'' ?>
            <a href="galerie_admin.php?collection=<?=$collection->id?>" <?=$activeId?>><?=$collection->nom?></a>
        <?php } ?>
    </div>

    <div id="current-collection">
        <!-- Le titre de la collection courante -->
        <h3><?=$result->collection->nom?></h3>
        <!-- Les images de la collection -->
        <div id="images">
            <?php for ($i=0 ; $i < count($result->images) ; $i++) {?>
                <div class="vignette">
                    <img src="<?=$result->images[$i]->path?>">
                    <form method="post" action="admin.php" id="delete_image_post_<?=$result->images[$i]->id?>">
                        <input type="hidden" name="action" value="delete_image">
                        <input type="hidden" name="id_collection" value="<?=$result->collection->id?>">
                        <input type="hidden" name="id_image" value="<?=$result->images[$i]->id?>">
                    </form>
                    <!-- Bouton de suppression de l'image -->
                    <button class="del_image_btn" onClick="onDeleteImagePressed(<?=$result->images[$i]->id?>);">X</button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Les images MODAL -->
<div class="modal" id="modal">

    <!-- Le bouton pour fermer la page -->
    <span class="close cursor" onclick="closeModal()">&times;</span>

    <div class="modal-content">
        <!-- Les images elles-meme -->
        <?php for ($i = 0 ; $i < count($result->images) ; $i++) { ?>
            <div class="mySlides"><img src="<?=$result->images[$i]->path?>"></div>
        <?php } ?>

        <!-- Next/previous controls -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
</div>

</body>
</html>