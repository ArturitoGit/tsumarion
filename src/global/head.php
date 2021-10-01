<?php

    // Recuperer toutes les collections
    require_once('services/Services.php') ;
    $all_collections = $Services->collectionProvider->getCollections() ;

    // Recuperer l'identite de la page
    if (!isset($page) or $page == null) {
        $page = '' ;
    }

?>

</head>
<body>

<script>
    window.onscroll = function() {scrollFunction()};
    // Changer la taille de l'entete on scroll
    function scrollFunction() {
        return ; // On annule la fonction
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("titre-site").style.fontSize = "var(--main-title-small-size)";
        } else {
            document.getElementById("titre-site").style.fontSize = "var(--main-title-size)";
        }
    }
</script>

<div id="menu">
    <!-- Le titre du site web -->
    <h1 id="titre-site">Atelier Mage</h1>

    <!-- Les liens vers les autres pages -->
    <div id="links">
        <!-- Le lien instagram -->
        <div class="link">
            <a href="https://www.instagram.com/atelier.mage/?hl=fr" id="instagram">
                <img src="Images/InstagramNB.png" alt="instagram" style="width:25px;">
            </a>
        </div>
        <!-- Lien vers la page contact -->
        <div class="link">
            <a href="contact.php" <?=($page == 'Contact') ? 'id="active-link"':''?>>Contact</a>
        </div>
        <!-- Lien vers la boutique -->
        <div class="link">
            <a href="boutique.php" <?=($page == 'Boutique') ? 'id="active-link"':''?>>Boutique</a>
        </div>
        <!-- Lien vers la galerie -->
        <div class="link">
            <a href="galerie.php" <?=($page == 'Galerie') ? 'id="active-link"':''?>>Galerie</a>
            <div class="sub-link">
                <!-- Liens vers les collections -->
                <?php for ($i = 0 ; $i < count($all_collections) ; $i++) { ?>
                    <a href="galerie.php?collection=<?=$all_collections[$i]->id?>"><?=$all_collections[$i]->nom?></a>
                <?php } ?>
            </div>
        </div>
        <!-- Lien vers l'accueil -->
        <div class="link">
            <a href="accueil.php" <?=($page == 'Accueil') ? 'id="active-link"':''?>>Accueil</a>
        </div>
    </div>
</div>
