<?php 
    // Authentification
    include("global/params.php") ;
    authentificate(0) ;
?>

<!DOCTYPE html>
<html>
<head>

    <!-- Global head -->
    <?php include("global/global_head.html") ?>

    <link rel="stylesheet" href="global/menu.css">
    <link rel="stylesheet" href="accueil/accueil.css">

    <title>Accueil</title>

</head>
<body>

<!-- Le menu du site --> 
<?php $active='accueil' ; include('global/menu.php') ?>

<!-- La partie présentation -->
<div class="container" id="container">   
    <div class="images">
        <img src="Images/Desc1.jpg" alt="Image3" id="Images/I3.jpg">
        <img src="Images/Desc2.jpg" alt="Image3" id="Images/I3.jpg">
        <img src="Images/Desc3.jpg" alt="Image3" id="Images/I3.jpg">    
    </div>
    
    <div class="description" id="desc">
        <h3>Objets outils, pour le quotidien de tous.</h3>
        <p>
        Je m’appelle Marion Grange, et je suis apprentie céramiste. 
        </p><p>
        Après des études de sciences politiques, je découvre, un peu par hasard la céramique. 
        Je me passionne immédiatement pour cet artisanat ancestral, 
        qui allie de façon magistrale la technique des Hommes, de leurs mains, 
        avec les aléas des éléments, et un matériau principal superbe : l’argile. 
        </p><p>
        Je m’inspire chaque jour de de la nature, et tente de l’utiliser ou de 
        l’inclure dans mes pièces sans la bafouer, en m’inscrivant dans une démarche 
        d’exploration des matériaux respectueuse des éléments.
        </p><p>
        J’aspire à une céramique utilitaire qui s’intègre comme outils dans le quotidien de tous. 
        </p><p>
        C’est pourquoi je voue une grande part de mon travail à réaliser des objets fonctionnels, 
        épurées mais harmonieuses, et des couleurs sobres. 
        </p>
    </div>
</div>
</body>

<script src="accueil/accueil.js"></script>

</html>