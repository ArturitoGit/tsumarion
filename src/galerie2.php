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
            display : flex ;
            flex-wrap : wrap ;
            justify-content : center ;
        }
        #images img {
            height : 30vh ;
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
        <a href="#">Collection 1</a>
        <a href="#">Collection 2</a>
        <a href="#">Collection 3</a>
    </div>

    <div id="current-collection">
        <h3>Ma collection courante</h3>

        <div id="images">
            <img src="Images\galerie\241485835_395954265447282_4398308958275222798_n.jpg">
            <img src="Images\galerie\241710889_568840714542039_9184749956607281013_n.jpg">
            <img src="Images\galerie\243132140_266504192002256_5917364163844464431_n.jpg">
            <img src="Images\galerie\243146154_407903944102636_3473920275527446541_n.jpg">
            <img src="Images\galerie\243149495_725717958828997_7310980197921468928_n.jpg">
            <img src="Images\galerie\243149994_578357003489661_1483602042068091331_n.jpg">
            <img src="Images\galerie\243151327_554075732582484_3396593264218028023_n.jpg">
            <img src="Images/galerie/Bison.jpg">
            <img src="Images/galerie/cameraman.jpg">
            <img src="Images/galerie/Bison.jpg">
            <img src="Images/galerie/Bison.jpg">
            <img src="Images/galerie/Bison.jpg">
        </div>
    </div>
</div>

</body>
</html>