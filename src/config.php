<?php

require_once 'config_param.php';

$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    echo 'Connection error.' . $conn->connect_error . '<br/>';
} else {
    echo 'Connection works.<br/>';
}