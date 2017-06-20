<?php

class Item {
    private $id;
    private $name;
    private $description;
    private $price;
    
    function __construct() {
        $this->id = -1;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getPrice() {
        return $this->price;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    public function saveToDB(mysqli $conn) {
        if($this->id == -1) {
            $name = $conn->real_escape_string($this->name);
            $description = $conn->real_escape_string($this->description);
            $price = $conn->real_escape_string($this->price);
            
            $sql = "INSERT INTO items (name, descriprion, price)
                VALUES ($name, $description, $price)";
            $result = $conn->quesry($sql);
            
            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE items SET name=$this->name, description=$this->description,
                    price=$this->price WHERE id=$this->id";
            $result = $conn->query($sql);
            
            if($result = TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }

};