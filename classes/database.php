<!-- This is the parent class of all classes communiating to database -->
<?php

class Database
{

    public function __construct()
    {
    }

    // Function to handle database connection
    protected function createDatabaseConnection()
    {
        // Add in details here
        $server = 'localhost';
        $username = 'root';
        $password = '';

        $schema = 'newspaper_db';

        $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        return $pdo;
    }

    // wrapper function to execute sql with criteria
    protected function executeWithCriteria($sql, $criteria)
    {
        $pdo = $this->createDatabaseConnection();

        $stmp = $pdo->prepare($sql);

        $stmp->execute($criteria);

        return $stmp;
    }

    // wrapper function to execute sql without criteria
    protected function executeSql($sql)
    {
        $pdo = $this->createDatabaseConnection();
        $stmp = $pdo->prepare($sql);

        $stmp->execute();

        return $stmp;
    }
}

?>