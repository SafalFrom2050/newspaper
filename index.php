<?php
    session_start();
    include 'header.php';
    include 'functions/check.php';


    if($_SESSION['logged_in']){
        load();
    }else{
        header("Location: account/login.php");
        die();
    }


    function load(){
        echo '<h1>You are logged in...</h1>';
        echo 'Is Admin: '.isCurrentUserAdmin();
        
    }

    include 'footer.php';
?>