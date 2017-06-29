<?php

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}
?>

<a href="./categories.php">Categories manager</a></br>
<a href="./items.php">Items manager</a></br>
<a href="./users.php">Users manager</a></br>
<a href="./orders.php">Orders manager</a>