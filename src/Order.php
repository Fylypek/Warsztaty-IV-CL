<?php

class Order {
    private $id;
    private $user_id;
    private $user_name;
    private $status_id;
    private $status_name;
    
    function __construct() {
        $this->id = -1;
        $this->user_id = "";
        $this->user_name = "";
        $this->status_id = "";
        $this->status_name = "";
    }
    
    function getId() {
        return $this->id;
    }
    
    function getUser_id() {
        return $this->user_id;
    }
    
    function getUser_name() {
        return $this->user_name;
    }
    
    function getStatus_id() {
        return $this->status_id;
    }
    
    function getStatus_name() {
        return $this->status_name;
    }
    
    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }
    
    function setUser_name($user_name) {
        $this->user_name = $user_name;
    }
    
    function setStatus_id($status_id) {
        $this->status_id = $status_id;
    }
    
    function setStatus_name($status_name) {
        $this->status_name = $status_name;
    }
    
    public function saveToDB(mysqli $conn) {
        $id = $conn->real_escape_string($this->id);
        $userId = $conn->real_escape_string($this->user_id);
        $statusId = $conn->real_escape_string($this->status_id);
        
        if ($this->id == -1) {
            $sql = "INSERT INTO orders (user_id, status_id)
                    VALUES ($userId, $statusId)";
            $result = $conn->query($sql);
            echo $conn->error;
            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE orders SET user_id=$userId, status_id=$statusId WHERE id=$id";
            $result = $conn->query($sql);
            
            if ($result == TRUE) {
                return true;
            }
        }
        return FALSE;
    }
    
    static public function loadAllOrders(mysqli $conn) {
        $sql = "SELECT o.id, o.user_id, u.name as user_name, s.name as status_name FROM orders o
                JOIN statuses s ON o.status_id=s.id
                JOIN users u ON o.user_id=u.id ORDER BY status_name ASC";
        $result = $conn->query($sql);
        $orders = [];

        if($result == TRUE && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedOrder = new Order();
                $loadedOrder->id = $row['id'];
                $loadedOrder->user_id = $row['user_id'];
                $loadedOrder->user_name = $row['user_name'];
                $loadedOrder->status_name = $row['status_name'];
                
                $orders[] = $loadedOrder;
            }
            return $orders;
        }
        return NULL;
    }
    
    static public function loadOrderById(mysqli $conn, $id) {
        $id = $conn->real_escape_string($id);
        $sql = "SELECT o.id, u.name as user_name, s.name as status_name FROM orders o
                JOIN users u ON o.user_id=u.id
                JOIN statuses s ON o.status_id=s.id
                WHERE o.id=$id";  
        $result = $conn->query($sql);

        if($result == TRUE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $loadedOrder = new Order();
            $loadedOrder->id = $row['id'];
            $loadedOrder->user_name = $row['user_name'];
            $loadedOrder->status_name = $row['status_name'];

            return $loadedOrder;
        }
        return NULL;
    }
    
    static public function loadOrdersByUser(mysqli $conn, $userId) {
        $userId = $conn->real_escape_string($userId);
        $sql = "SELECT o.id, s.name as status_name FROM orders o
                JOIN statuses s ON o.status_id=s.id 
                WHERE user_id=$userId";  
        $result = $conn->query($sql);
        $orders = [];

        if($result == TRUE && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedOrder = new Order();
                $loadedOrder->id = $row['id'];
                $loadedOrder->status_name = $row['status_name'];
                
                $orders[] = $loadedOrder;
            }
            return $orders;
        }
        return NULL;
    }
    
    public function delete(mysqli $conn) {

        if($this->id != -1) {
            $sql = "DELETE FROM orders WHERE id=$this->id";
            $result = $conn->query($sql);
            
            if($result == TRUE) {
                $this->id = -1;
                return true;
            }
            return FALSE;
        }
        return TRUE;
    }
}
?>