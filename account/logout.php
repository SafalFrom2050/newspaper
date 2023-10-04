<?php
session_start();

// destroy session, delete variables and logout
session_destroy();

// return to login page
header("Location: login.php");
die();
