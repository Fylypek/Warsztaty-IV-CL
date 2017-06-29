<?php

require_once './../src/User.php';
require_once './../src/config.php';

session_start();

if(!isset($_SESSION['adminId'])) {
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['userId'])) {
        $user = user::loadUserByID($conn, $_GET['userId']);
        $user->delete($conn);
        echo 'user deleted';
    }
}

?>
<html>
<!-- List of users -->
    <h4>Users list</h4>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th></th>
                <th></th>
            </tr>';
            <?php
            $users = User::loadAllUsers($conn);
            for($i = 0; $i < count($users); $i++) {
                echo '<tr>
                        <td>'.$users[$i]->getName().'</td>
                        <td>'.$users[$i]->getEmail().'</td>
                        <td>'.$users[$i]->getAddress().'</td>
                        <td><a href="user.php?userId='.$users[$i]->getId().'">Orders</a></td>
                        <td><a href="users.php?userId='.$users[$i]->getId().'">Delete</a></td>
                    </tr>';
            }
            ?>
            </table>
</html>