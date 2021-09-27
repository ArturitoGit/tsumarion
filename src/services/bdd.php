<?php

    // Access to the data base
    $host = 'db' ;
    $user = 'MYSQL_USER' ;
    $pass = 'MYSQL_PASSWORD' ;
    $database = 'tsumarion' ;

    static $bdd ;
    $bdd = new mysqli($host,$user,$pass,$database) ;
?>