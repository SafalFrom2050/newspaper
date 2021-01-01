<?php

session_start();
include ('../classes/database.php');
include ('../classes/user.php');
$user = new User();

if(isset($_POST['username'])){
    
    $user = $user->verifyUserCredentials($_POST['username'], $_POST['password']);

    if(!is_null($user)){
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user->user_id;

        echo '<h1>Redirecting to the homepage</h1>';
        
        header("Location: /");
        die();
    }else{
        echo '<h1>Check your email/password...</h1>';
        echo '<a href=login.php>Try Again</a>';
    }
}
?>