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

<!-- Le contenu de la page -->
<div class="container">

    <!-- Le titre de la collection -->
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9 titre-collection"> 
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
                        <a href="galerie.php?collection=<?=$i_collection->id?>"<?=$id_active?>><?=$i_collection->nom?></a>
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
                    </div>
                    <?php $i += 3 ; 
                } ?>
            </div>
        <?php } ?>
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