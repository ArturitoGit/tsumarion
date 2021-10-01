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

    <title>Galerie</title>

    <style>
        #galerie-page {
            /* Placer la colonne des autres collections a gauche des images */ 
            margin-top : 8% ;
            /* Les proportions de la page en largeur */
            --left-column-width : 20% ;
            --right-page-width : 80% ;
        }
        #autres-collections {
            width : var(--left-column-width) ;
            position : fixed ;
            /* Aligner le bloc des autres collections verticalement */
            display : flex ;
            flex-direction : column ;
            margin-top : 20vh ;
            /* Distance avec le bord gauche de la fenetre */
            padding-left : 3% ;
        }
        #current-collection {
            /* Laisser de l'espace pour la colonne de gauche */
            width : var(--right-page-width) ;
            margin-left : var(--left-column-width) ;
            /* Marge entre la colonne et la collection courante */
            padding-left : 5% ;
        }
        #autres-collections a {
            font-size : 1.5em ;
        }
        h3 {
            font-weight : bold ;
            margin-bottom : 3% ;
        }
        #current-collection h3 {
            font-size : 2em;
        }
        #images {
        }
        #images img {
            width : 22vw ;
            height : 22vw ;
            display : inline-block ;
            margin : 1% ;
        }
    </style>

</head>
<body>

<!-- Le menu du site --> 
<?php $page='Galerie' ; include('global/head.php') ?>

<div id="galerie-page">
    <!-- La colonne des autres collections -->
    <div id="autres-collections">
        <h3>Autres collections</h3>
        <?php for ($i = 0 ; $i < count($result->all_collections) ; $i ++) { ?>
            <a href="galerie.php?collection=<?=$result->all_collections[$i]->id?>"><?=$result->all_collections[$i]->nom?></a>
        <?php } ?>
    </div>

    <div id="current-collection">
        <!-- Le titre de la collection courante -->
        <h3><?=$result->collection->nom?></h3>
        <!-- Les images de la collection -->
        <div id="images">
            <?php for ($i=0 ; $i < count($result->images) ; $i++) {?>
                <img src="<?=$result->images[$i]->path?>">
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