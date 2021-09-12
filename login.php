<?php

    session_start() ; // Ouverture de la session

    $bdd = new PDO('mysql:host=localhost;dbname=tsumarion;charset=utf8', 'root', '');

    $failed_login = false ;

    // Recuperation des potentiels parametres
    if (isset($_POST['pseudo']) AND isset($_POST['pwd'])) {
        $pseudo = $_POST['pseudo'] ;
        $pwd = $_POST['pwd'] ;
        $salt = "@|-°+==04601doQ" ;
        $hashe = md5($salt.$pseudo.$salt.$pwd.$salt) ;
        // Verification dans la base de données
        $req = $bdd->prepare("SELECT * FROM admin WHERE pseudo=? AND pwd=?") ;
        $req->execute(array($pseudo,$hashe)) ;
        $response = $req->fetch() ;
        if ($response) {
            // Authentification reussie
            // Ajout de la connexion dans les informations de session
            $_SESSION['connected'] = true ;
        } else {
            // Echec d'authentification
            $failed_login = true ;
        }
    }

    // Redirection vers galerie_admin en cas de connexion
    if (isset($_SESSION['connected']) AND $_SESSION['connected'] == true) {
        header('Location: galerie_admin.php') ;
        exit() ;
    }

?>

<html>
    <head>

        <!-- Global head -->
        <?php include("global/global_head.html") ?>

        <link rel="stylesheet" href="global/login.css">

        <title>Authentification</title>
    </head>
    <body>
        <h1>Authentification</h1>

        <p>Vous essayez de rentrer dans la partie sécurisée du site web.<br/> Vous êtes probablement
        Marion ou Arthur, mais je vais devoir vous demander de vous identifer :</p>

        <form method="POST" action ="login.php" id="form">
            <div class="form-group">
                <label for="pseudo">Pseudo :</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo">
            </div>
            <div class="form-group">
                <label for="pwd">Mot de passe :</label>
                <input type="password" class="form-control" name="pwd" id="pwd">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Se connecter">
            </div>
        </form>

        <?php if ($failed_login) { ?>
            <p>Le pseudo ou le mot de passe est incorrect ...</p>
        <?php }elseif (isset($_SESSION['connected']) AND $_SESSION['connected'] == true) { ?>
            <p>Vous voila connectes </p>
        <?php } ?>

    </body>
</html>