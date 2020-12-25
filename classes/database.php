<?php

class Database{

    public function __construct() {
        
    }

    protected function createDatabaseConnection(){
        $server = 'localhost'; 
        $username = 'root'; 
        $password = ''; 

        $schema ='newspaper_db';

        $pdo = new PDO('mysql:dbname='.$schema.';host='.$server , $username, $password, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
    
        return $pdo;
    }

    protected function executeWithCriteria($sql, $criteria){
        $pdo = $this->createDatabaseConnection();
    
        $stmp = $pdo->prepare($sql);

        $stmp->execute($criteria);

        return $stmp;
    }

    protected function executeSql($sql){
        $pdo = $this->createDatabaseConnection();
        $stmp = $pdo->prepare($sql);

        $stmp->execute();

        return $stmp;
    }
}

?>