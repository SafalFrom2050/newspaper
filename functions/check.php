<?php
include ('utils/database_connection.php');

function isCurrentUserAdmin(){
    $user_id = $_SESSION['user_id'];

    $pdo = createDatabaseConnection();
    $stmp = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');

    $criteria = [
        'user_id' => $user_id
    ];

    $stmp->execute($criteria);

    $user = $stmp->fetch();

    return $user['is_admin'];
}

?>