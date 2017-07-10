<?php

class Status {
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
            $sql = "INSERT INTO statuses (name) VALUES ('$name')";
            $result = $conn->query($sql);

            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE statuses SET name='$name'";
            $result = $conn->query($sql);

            if($result == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    static public function loadAllStatuses(mysqli $conn) {
        $sql = "SELECT * FROM statuses";
        $result = $conn->query($sql);
        $statuses = [];
        
        if($result == TRUE && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedStatus = new Status();
                $loadedStatus->id = $row['id'];
                $loadedStatus->name = $row['name'];
                
                $statuses[] = $loadedStatus;
            }
            return $statuses;
        }
        return NULL;
    }

    public function delete(mysqli $conn) {
        if($this->id != -1) {
            $id = $conn->real_escape_string($this->id);
            $sql = "DELETE FROM statuses WHERE id=$id";
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