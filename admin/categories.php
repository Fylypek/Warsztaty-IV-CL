<?php

require_once './../src/Category.php';
require_once './../src/config.php';

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['name']) && strlen(trim($_POST['name'])) >=3) {
        $newCategory = new Category();
        $newCategory->setName($_POST['name']);
        
        if($newCategory->saveToDB($conn)) {
            echo 'success';
        }
    }
}

?>
<html>
<!-- List of categories -->
    <ul>
        <?php
            $categories = Category::loadAllCategories($conn);
            for($i = 0; $i < count($categories); $i++) {
                echo '<li>'.$categories[$i]->getName().'</li></br>';
            }
        ?>
    </ul>

    <form action="#" method="POST">
        <input type="text" name="name">
        <input type="submit" value="Add category">
    </form>
</html>