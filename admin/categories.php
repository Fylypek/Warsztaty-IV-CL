<?php

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}


?>

<-- List of categories -->
$categories
