<?php

    session_start() ; // Ouverture de la session

    // Params
    include('global/params.php') ;

    require_once 'features/Login.php' ;
    require_once 'services/Services.php' ;

    $failed_login = false ;

    // Recuperation des potentiels parametres
    if (isset($_POST['pseudo']) AND isset($_POST['pwd'])) {
        $pseudo = $_POST['pseudo'] ;
        $pwd = $_POST['pwd'] ;

        // Appel a la fonctionnalite de connexion
        $request = new LoginRequest($pseudo,$pwd) ;
        $result = (new Loginhandler($Services))->Handle($request) ;

        // Si succes de l'authentification
        if ($result->success) {
            $_SESSION['connected'] = true ;
        // Si echec de l'authentification
        } else {
            $failed_login = true ;
        }
    }

    // Cible par default
    $cible = 0 ;
    // Recuperation de la cible
    if (isset($_GET['cible'])) {
        $param_cible = intval($_GET['cible']) ;
        // Si param_cible correspond a l'identifiant d'une des pages de params.php
        if ($param_cible < $nb_pages AND $param_cible >= 0) {
            $cible = $param_cible ;
        }
    } else {
        echo "pas de cible" ;
        exit() ;
    }

    // Redirection vers la cible en cas de connexion
    if (isset($_SESSION['connected']) AND $_SESSION['connected'] == true) {
        header('Location: '. $pages[$cible]) ;
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

        <form method="POST" action ="login.php?cible=<?=$cible?>" id="form">
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