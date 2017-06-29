<?php

require_once './../src/User.php';
require_once './../src/Order.php';
require_once './../src/config.php';

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if($_GET['userId']) {
        $user = User::loadUserById($conn, $_GET['userId']);
        $orders = Order::loadOrdersByUser($conn, $user->getId());
    } else {
        header('Location: users.php');
        exit();
    }
}
?>

<html>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th></th>
        </tr>
        <?php
            echo '<tr>
                    <td>'.$user->getName().'</td>
                    <td>'.$user->getEmail().'</td>
                    <td>'.$user->getAddress().'</td>
                    <td><a href="users.php?userId='.$user->getId().'">Delete</a></td>
                </tr>';
        ?>
    </table>
    
    <h3>Orders</h3>
    <?php
        if($orders == NULL) {
            echo '<p>No orders.';
        } else {
    ?>
        <table>
            <tr>
                <th>Id</th>
                <th>Status</th>
                <th></th>
            </tr>
    <?php
            foreach($orders as $order) {
                echo '<tr>
                        <td>'.$order->getId().'</td>
                        <td>'.$order->getStatus_id().'</td>
                        <td><a href="order.php?orderId='.$order->getId().'">Show more</a></td>
                    </tr>';
            }
        }
    ?>
</html>