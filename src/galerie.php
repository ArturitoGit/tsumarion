<?php

    // Authentification
    include("global/params.php") ;
    authentificate(1) ;

    // BDD
    include('global/bdd.php') ;

    function getDefaultId($bdd) {
        $response = $bdd->query("SELECT id FROM collections")->fetch_assoc() ;
        if (!$response) {
            // S'il n'y a pas de collections dans la liste -> redirection
            header('Location: accuil.html');
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
    $sql = "SELECT path FROM images WHERE collection=?" ;
    $req = $bdd->prepare($sql) ; 
    $req->bind_param('i',$id_col) ;
    $req->execute() ;
    $result = $req->get_result() ;
    $images = $result->fetch_all(MYSQLI_ASSOC) ;
    $len_images = $result->num_rows ;

    // Toutes les collections   
    $sql = "SELECT nom,id FROM collections" ;
    $req = $bdd->prepare($sql) ;
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
    <script src="galerie/modal.js"></script>

    <title>Galerie</title>

</head>
<body>

<!-- Le menu du site --> 
<?php $active='galerie' ; include('global/menu.php') ?>

<!-- Le contenu de la page -->
<div class="container">

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
                for ($i = 0 ; $i < $len_collections ; $i++) { 
                    // Permet d'ajouter l'id "active" sur le lien de la collection courante
                    $id_active = ($collections[$i]['id'] == $id_col) ? "id='active'" : "" ;?>
                    <li>
                        <a href="galerie.php?collection=<?=$collections[$i]['id']?>"<?=$id_active?>><?=$collections[$i]['nom']?></a>
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
                while ($i < $len_images) { ?>
                    <!-- Une colonne d'images -->
                    <div class="vignette">
                        <img src="<?=$images[$i]['path']?>"  onclick="openModal();currentSlide(<?=$i+1?>)">
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
        <?php for ($i = 0 ; $i < $len_images ; $i++) { ?>
            <div class="mySlides"><img src="<?=$images[$i]['path']?>"></div>
        <?php } ?>

        <!-- Next/previous controls -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
</div>

</body>
</html>