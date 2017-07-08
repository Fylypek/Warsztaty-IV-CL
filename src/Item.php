<?php

class Item {
    private $id;
    private $name;
    private $description;
    private $price;
    private $quantity;
            
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
    
    function getQuantity() {
        return $this->quantity;
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
    
    function setQuantity($quantity) {
        $this->quantity = $quantity;
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
            $sql = "UPDATE items SET name='$name', description='$description',
                    price=$price WHERE id=$id";
            $result = $conn->query($sql);

            if($result == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    static public function loadAllItems(mysqli $conn) {
        $sql = "SELECT * FROM items";
        $result = $conn->query($sql);
        $items = [];
        
        if($result == TRUE && $result->num_rows != 0) {
            foreach ($result as $row) {
                $loadedItem = new Item();
                $loadedItem->id = $row['id'];
                $loadedItem->name = $row['name'];
                $loadedItem->description = $row['description'];
                $loadedItem->price = $row['price'];
                
                $items[] = $loadedItem;
            }
            return $items;
        }    
        return NULL;
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
    
    static public function loadItemsByOrderId(mysqli $conn, $orderId) {
        $orderId = $conn->real_escape_string($orderId);
        $sql = "SELECT i.name, io.quantity FROM item_order io
                JOIN items i ON i.id=io.item_id
                WHERE io.order_id=$orderId";
        $result = $conn->query($sql);
        $items = [];
        
        if($result == TRUE && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedItem = new Item();
                $loadedItem->name = $row['name'];
                $loadedItem->quantity = $row['quantity'];
                
                $items[] = $loadedItem;
            }
            return $items;
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
