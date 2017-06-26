<?php

session_start();

if(isset($_SESSION['adminId'])) {
    header('Location: index.php');
    exit();
}

require_once '../src/Admin.php';
require_once '../src/config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['email']) && strlen(trim($_POST['email'])) >=5
        && isset($_POST['password']) && strlen(trim($_POST['password'])) >= 5) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $admin = Admin::loadAdminByEmail($conn, $email);
        if($admin) {
            if(password_verify($password, $admin->getPassword())) {
                $_SESSION['adminId'] = $admin->getId();
                header('Location: index.php');
            }
        } 
    }
    echo 'Wrong login or password.';
} 

?>

<form method="POST" action="#">
    <input name="email" type="email">
    <input name="password" type="password">
    <button type="submit">Sign in</button>
</form>

