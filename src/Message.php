<?php

class Message {
    private $id;
    private $user_id;
    private $order_id;
    private $message;
    
    function __construct() {
        $this->id = -1;
        $this->user_id = "";
        $this->order_id = "";
        $this->message = "";
    }
    function getId() {
        return $this->id;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getOrder_id() {
        return $this->order_id;
    }

    function getMessage() {
        return $this->message;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    function setOrder_id($order_id) {
        $this->order_id = $order_id;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    public function saveToDB(mysqli $conn) {
        $id = $conn->real_escape_string($this->id);
        $user_id = $conn->real_escape_string($this->user_id);
        $order_id = $conn->real_escape_string($this->order_id);
        $message = $conn->real_escape_string($this->message);
        
        if($this->id == -1) {
            $sql = "INSERT INTO messages (user_id, order_id, message)
                VALUES ($user_id, $order_id, '$message')";
            $result = $conn->query($sql);

            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE messages SET user_id=$user_id, order_id=$order_id,
                    message='$message' WHERE id=$id";
            $result = $conn->query($sql);

            if($result == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
        static public function loadMessageByID(mysqli $conn, $id) {
        $id = $conn->real_escape_string($id);

        $sql = "SELECT * FROM messages WHERE id=$id";
        $result = $conn->query($sql);

        if($result == TRUE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->user_id = $row['user_id'];
            $loadedMessage->order_id = $row['order_id'];
            $loadedMessage->message = $row['message'];

            return $loadedMessage;
        }    
        return NULL;
    }
}