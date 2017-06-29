<?php

require_once './../src/Item.php';
require_once './../src/config.php';

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}

switch($_SERVER['REQUEST_METHOD']) {
    case'POST':
        if(isset($_POST['name']) && strlen(trim($_POST['name'])) >=3
            && isset($_POST['description']) && strlen(trim($_POST['description'])) >=3
            && isset($_POST['price']) && is_numeric($_POST['price'])) {
            $newItem = new Item();
            $newItem->setName($_POST['name']);
            $newItem->setDescription($_POST['description']);
            $newItem->setPrice($_POST['price']);

            if($newItem->saveToDB($conn)) {
                echo 'Item added';
            }
        }
        break;
    case 'GET':
        if(isset($_GET['itemId'])) {
            $item = Item::loadItemByID($conn, $_GET['itemId']);
            $item->delete($conn);
            echo 'Item deleted';
        }
        break;
}

?>
<html>
<!-- List of items -->
    <ul>
        <?php
            $items = Item::loadAllItems($conn);
            echo '<table>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th></th>
                    </tr>';
            for($i = 0; $i < count($items); $i++) {
                echo '<tr>
                        <td>'.$items[$i]->getName().'</td>
                        <td>'.$items[$i]->getDescription().'</td>
                        <td>'.$items[$i]->getPrice().'</td>
                        <td><a href="items.php?itemId='.$items[$i]->getId().'">Delete</a></td>
                    </tr>';
            }
            echo '</table>';
        ?>
    </ul>

    <form action="#" method="POST">
        <input type="text" name="name" required>
        <input type="text" name="description" required>
        <input type="number" name="price" min="0" step="0.01" required>
        <input type="submit" value="Add item">
    </form>
</html>