<?php 
    // Authentification
    include("global/params.php") ;
    authentificate(3) ;
?>

<!DOCTYPE html>
<html>
<head>

    <!-- Global head -->
    <?php include("global/global_head.html") ?>
    
    <link rel="stylesheet" href="global/menu.css">
    <link rel="stylesheet" href="contact/contact.css">

    <title>Contact</title>

</head>
<body>

<!-- Le menu du site --> 
<?php $active='contact' ; include('global/menu.php') ?>

<div class="container">

    <h2><b>Me contacter</b></h2>

    <p>Veuillez laisser un message ici, avec votre adresse email,
        je vous répondrai dès que possible. </p>
    
    <form method="POST" action="contact.php" id="form_contact">
        <div class="form-group">
            <label for="mail_input">Votre adresse mail</label>
            <input type="text" name="email" class="form-control" placeholder="my@email.com" id="mail_input"/>
        </div>
        <div class="form-group">
            <label for="message_input">Votre message</label>
            <textarea name="message" class="form-control" placeholder="Mon message" id="message_input" rows="7"></textarea>
        </div>
        <button type="submit" class="btn btn-info">Envoyer</button>
    </form>

</div>


</body>
</html>