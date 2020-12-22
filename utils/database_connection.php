<?php

function createDatabaseConnection(){
    $server = 'localhost'; 
    $username = 'root'; 
    $password = ''; 

    $schema ='newspaper_db';

    $pdo = new PDO('mysql:dbname='.$schema.';host='.$server , $username, $password, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
    
    return $pdo;
}

?>