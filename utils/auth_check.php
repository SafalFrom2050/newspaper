<?php

if(!$_SESSION['logged_in']){
    header("Location: account/login.php");
    die();
}

?>