<?php

    include('services/Services.php') ;
    include('features/InitGallery.php') ;

    $request = new InitGalleryRequest(21) ;
    $result = (new InitGalleryHandler($Services))->Handle($request) ;

    echo ($result->success ? "Success" : "Failure") ;
    echo("</br>") ;
    echo (count($result->all_collections)) ;
    echo("</br>") ;
    echo ($result->collection->nom) ;
    echo("</br>") ;
    foreach ($result->images as $image) {
        echo $image->path ;
    }

?>