<?php

class Item {
    private $id;
    private $name;
    private $description;
    private $price;
    
    function __construct() {
        $this->id = -1;
        $this->name = "";
        $this->description = "";
        $this->price = "";
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
        $id = $conn->real_escape_string($this->id);
        $name = $conn->real_escape_string($this->name);
        $description = $conn->real_escape_string($this->description);
        $price = $conn->real_escape_string($this->price);
        
        if($this->id == -1) {
            $sql = "INSERT INTO items (name, description, price)
                VALUES ('$name', '$description', $price)";
            $result = $conn->query($sql);

            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            echo 'jestem';
            $sql = "UPDATE items SET name='$name', description='$description',
                    price=$price WHERE id=$id";
            $result = $conn->query($sql);

            if($result == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    static public function loadItemByID(mysqli $conn, $id) {
        $id = $conn->real_escape_string($id);

        $sql = "SELECT * FROM items WHERE id=$id";
        $result = $conn->query($sql);
        
        if($result == TRUE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedItem = new Item();
            $loadedItem->id = $row['id'];
            $loadedItem->name = $row['name'];
            $loadedItem->description = $row['description'];
            $loadedItem->price = $row['price'];

            return $loadedItem;
        }    
        return NULL;
    }

    public function delete(mysqli $conn) {
        if($this->id != -1) {
            $id = $conn->real_escape_string($this->id);
            $sql = "DELETE FROM items WHERE id=$id";
            $result = $conn->query($sql);
            
            if($result == TRUE) {
                $this->id = -1;
                return TRUE;
            }
            return FALSE;
        }
        return TRUE;
    } 
};
