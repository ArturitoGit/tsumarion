<?php

    include('features/SendMail.php') ;

    $request = new SendMailRequest("expe.diteur@gmail.com","mon message") ;
    
    echo (new SendMailHandler())->Handle($request) ? "Mail envoyé !" : "Mail non envoyé ..." ;

?>