<?php 
    // Authentification
    include("global/params.php") ;
    authentificate(2) ;
?>

<!DOCTYPE html>
<html>
<head>

    <!-- Global head -->
    <?php include("global/global_head.html") ?>
    <link rel="stylesheet" href="global/head.css">
    <link rel="stylesheet" href="boutique/boutique.css">

    <title>Boutique</title>

</head>
<body>

<!-- Le menu du site --> 
<?php $page='Boutique' ; include('global/head.php') ?>

<div class="container">
    <h2>La boutique ouvrira bientôt !</h2>
</div>


</body>
</html>