<?php

require_once './../src/Order.php';
require_once './../src/config.php';

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['orderId'])) {
        $order = Order::loadOrderById($conn, $_GET['orderId']);
        $order->delete($conn);
        echo 'Order deleted.';
    }
}

?>
<html>
<!-- List of orders -->
    <h4>Orders list</h4>
        <table>
            <tr>
                <th>Id</th>
                <th>User name</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            $orders = Order::loadAllOrders($conn);
            for($i = 0; $i < count($orders); $i++) {
                echo '<tr>
                        <td>'.$orders[$i]->getId().'</td>
                        <td>'.$orders[$i]->getUser_name().'</td>
                        <td>'.$orders[$i]->getStatus_name().'</td>
                        <td><a href="order.php?orderId='.$orders[$i]->getId().'">Show more</a></td>
                        <td><a href="orders.php?orderId='.$orders[$i]->getId().'">Delete</a></td>
                    </tr>';
            }
            ?>
            </table>
</html>