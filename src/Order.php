<?php

class Order {
    private $id;
    private $user_id;
    private $status_id;
    
    function __construct() {
        $this->id = -1;
        $this->user_id = "";
        $this->status_id = "";
    }
    
    function getId() {
        return $this->id;
    }
    function getUser_id() {
        return $this->user_id;
    }
    function getStatus_id() {
        return $this->status_id;
    }
    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }
    function setStatus_id($status_id) {
        $this->status_id = $status_id;
    }
    
    
}

?>