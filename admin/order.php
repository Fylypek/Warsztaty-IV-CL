<?php


require_once './../src/Order.php';
require_once './../src/config.php';

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if($_GET['orderId']) {
        $order = Order::loadOrderById($conn, $_GET['orderId']);
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
    </table>
</html>