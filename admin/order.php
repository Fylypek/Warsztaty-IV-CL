<?php


require_once './../src/Order.php';
require_once './../src/Item.php';
require_once './../src/Status.php';
require_once './../src/config.php';

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if(isset($_POST['id']) && isset($_POST['userId']) && isset($_POST['statusId'])) {
            $order = Order::loadOrderById($conn, $_POST['id']);
            $order->setStatus_id($_POST['statusId']);
            if($order->saveToDB($conn)) {
            echo'Status changed';
            }
        }
    case 'GET':
        if($_GET['orderId']) {
            $order = Order::loadOrderById($conn, $_GET['orderId']);
            $items = Item::loadItemsByOrderId($conn, $_GET['orderId']);
            $statuses = Status::loadAllStatuses($conn);
        } else {
            header('Location: orders.php');
            exit();
        }
}

?>

<html>
    <table>
        <tr>
            <th>Id</th>
            <th>User name</th>
            <th>Status</th>
            <th></th>
        </tr>
        <?php
            echo '<tr>
                    <td>'.$order->getId().'</td>
                    <td>'.$order->getUser_name().'</td>
                    <td>'.$order->getStatus_name().'</td>
                </tr>';
        ?>
    </table><br/>
        
    <table>
        <tr>
            <th>No.</th>
            <th>Item name</th>
            <th>Quantity</th>
        </tr>
        <?php
            $i = 1;
            foreach($items as $row) {
                echo '<tr>
                        <td>'.$i.'</td>
                        <td>'.$row->getName().'</td>
                        <td>'.$row->getQuantity().'</td>
                    </tr>';
                $i++;
            }
        ?>
    </table><br/>
    
    <form method="POST" action="#">
        <?php
        echo
        '<input type="number" name="id" value="'.$order->getId().'" readonly>
        <input type="number" name="userId" value="'.$order->getUser_id().'" readonly>
        <select name="statusId">';
        foreach ($statuses as $row) {
            echo '<option value="'.$row->getId().'">'.$row->getName().'</option>';
        }
        ?>
        </select>
        <input type="submit" value="Zmień">
    </form>
</html>