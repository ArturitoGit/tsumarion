<?php

    // Recuperer toutes les collections
    include('services/Services.php') ;
    $all_collections = $Services->collectionProvider->getCollections() ;

    // La page appelante doit definir le parametre $active,
    // cette fonction permet de placer l'identifiant active devant la
    // bonne page du menu
    function isActive($page,$active) {
        if ($page==$active) {
            return("id='active'") ;
        } else {
            return("") ;
        }
    }
?>

<!-- Le fond de la page -->
<div class="bg" id="bg"></div> 

<!-- Le titre du site -->
<h1 id="titre">Atelier MAGE</h1>

<!-- Le menu du site -->
<div class="menu">
    <a href="https://www.instagram.com/atelier.mage/?hl=fr" id="instagram">
        <img src="Images/InstagramNB.png" alt="instagram" style="width:25px;">
    </a>
    <a href="contact.php" <?=isActive("contact",$active)?>>Contact</a>
    <a href="boutique.php" <?=isActive("boutique",$active)?>>Boutique</a>
    <div class="dropdown">
        <a href="galerie.php" <?=isActive("galerie",$active)?> class="btn">Galerie</a>
        <div class="liens">
            <?php // Boucle sur toutes les collections
            foreach ($all_collections as $col) { ?>
                <a href="galerie.php?collection=<?=$col->id?>"><?=$col->nom?></a>
            <?php } ?>
        </div>
    </div>
    <a href="accueil.php" <?=isActive("accueil",$active)?>>Accueil</a>
</div>