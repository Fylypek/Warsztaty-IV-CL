<?php

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}
?>

<a href="./categories.php">Categories manager</a>