<?php

class Category {
    private $id;
    private $name;
    
    function __construct() {
        $this->id = -1;
        $this->name = "";
    }
    
    function getId() {
        return $this->id;
    }
    function getName() {
        return $this->name;
    }
    function setName($name) {
        $this->name = $name;
    }
    
    public function saveToDB(mysqli $conn) {
        $id = $conn->real_escape_string($this->id);
        $name = $conn->real_escape_string($this->name);
        
        if($this->id == -1) {
            $sql = "INSERT INTO categories (name) VALUES ('$name')";
            $result = $conn->query($sql);

            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE categories SET name='$name'";
            $result = $conn->query($sql);

            if($result == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    static public function loadAllCategories(mysqli $conn) {
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);
        $categories = [];
        
        if($result == TRUE && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedCategory = new Category();
                $loadedCategory->id = $row['id'];
                $loadedCategory->name = $row['name'];
                
                $categories[] = $loadedCategory;
            }
        }
        return $categories;        
    }
    
    static public function loadCategoryByID(mysqli $conn, $id) {
        $id = $conn->real_escape_string($id);

        $sql = "SELECT * FROM categories WHERE id=$id";
        $result = $conn->query($sql);
        
        if($result == TRUE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedCategory = new Category();
            $loadedCategory->id = $row['id'];
            $loadedCategory->name = $row['name'];

            return $loadedCategory;
        }    
        return NULL;
    }
    
    public function delete(mysqli $conn) {
        if($this->id != -1) {
            $id = $conn->real_escape_string($this->id);
            $sql = "DELETE FROM categories WHERE id=$id";
            $result = $conn->query($sql);
            
            if($result == TRUE) {
                $this->id = -1;
                return TRUE;
            }
            return FALSE;
        }
        return TRUE;
    } 
}
?>