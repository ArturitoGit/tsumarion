<?php

    include('services/Services.php') ;

    $collections = $Services->collectionProvider->getCollections() ;
    echo $collections[0]->nom ;
    echo "</br>" ;
    echo $collections[1]->nom ;
    echo "</br>" ;
    echo $collections[2]->nom ;
    echo "</br>" ;

?>