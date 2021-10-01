<?php
    // Authentification
    include("global/params.php") ;
    authentificate(1) ;

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
    <link rel="stylesheet" href="galerie/modal.css">
    <script src="galerie/modal.js"></script>

    <title>Galerie</title>

</head>
<body>

<!-- Le menu du site --> 
<?php $page='Galerie' ; include('global/head.php') ?>

<div id="galerie-page">
    <!-- La colonne des autres collections -->
    <div id="autres-collections">
        <h3>Autres collections</h3>
        <?php for ($i = 0 ; $i < count($result->all_collections) ; $i ++) { 
                    $collection = $result->all_collections[$i] ;
                    $activeId = $collection->id == $result->collection->id ? 'id="active-collection"':'' ?>
            <a href="galerie.php?collection=<?=$collection->id?>" <?=$activeId?>><?=$collection->nom?></a>
        <?php } ?>
    </div>

    <div id="current-collection">
        <!-- Le titre de la collection courante -->
        <h3><?=$result->collection->nom?></h3>
        <!-- Les images de la collection -->
        <div id="images">
            <?php for ($i=0 ; $i < count($result->images) ; $i++) {?>
                <div class="vignette">
                    <img src="<?=$result->images[$i]->path?>" onclick="openModal();currentSlide(<?=$i+1?>)">
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