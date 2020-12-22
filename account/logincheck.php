<?php

session_start();

include ('../utils/database_connection.php');

$pdo = createDatabaseConnection();

if(isset($_POST['username'])){
    $stmp = $pdo->prepare('SELECT * FROM users WHERE username = :username');

    $criteria = [
        'username' => $_POST['username']
    ];

    $stmp->execute($criteria);

    $user = $stmp->fetch();

    if(password_verify($_POST['password'], $user['password'])){
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['user_id'];
        echo '<h1>Heyyyy '.$user['name'].'</h1>';
        echo '<a href=/>Home</a>';
    }else{
        echo '<h1>Check your email/password...</h1>';
        echo '<a href=login.php>Try Again</a>';
    }
}
?>