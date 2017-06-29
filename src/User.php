<?php

class User 
{  
    private $id;
    private $name;
    private $email;
    private $password;
    private $address;
    
    function __construct() {
        $this->id = -1;
        $this->name = "";
        $this->email = "";
        $this->password = "";
        $this->address = "";
    }

    function getId() {
        return $this->id;
    }
    
    function getName() {
        return $this->name;
    }
        
    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }      
    
    function getAddress() {
        return $this->address;
    }
    
    function setName($name) {
        $this->name = $name;
    }
    
    function setEmail($email) {
        $this->email = $email;
    }
    
    function setPassword($password) {
        $options = ['cost' => 11];
        $this->password = password_hash($password, PASSWORD_DEFAULT, $options);
    }

    function setAddress($address) {
        $this->address = $address;
    }

    public function saveToDB(mysqli $conn) {
        $id = $conn->real_escape_string($this->id);
        $name = $conn->real_escape_string($this->name);
        $email = $conn->real_escape_string($this->email);
        $password = $conn->real_escape_string($this->password);
        $address = $conn->real_escape_string($this->address);
        
        if ($this->id == -1) {
            $sql = "INSERT INTO users (name, email, password, address)
                    VALUES ('$name', '$email', '$password', '$address')";
            $result = $conn->query($sql);
            
            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE users SET name='$name', email='$email',
                    password='$password', address='$address' WHERE id=$id";
            $result = $conn->query($sql);
            
            if ($result == TRUE) {
                return true;
            }
        }
        return FALSE;
    }
    
    static public function loadUserById(mysqli $conn, $id) {
        $id = $conn->real_escape_string($id);
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = $conn->query($sql);
        
        if ($result == TRUE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->name = $row['name'];
            $loadedUser->email = $row['email'];
            $loadedUser->password = $row['password'];
            $loadedUser->address = $row['address'];
            
            return $loadedUser;
        }
        return NULL;
    }
    
    static public function loadUserByEmail(mysqli $conn, $email) {
        $email = $conn->real_escape_string($email);
        $sql = "SELECT * FROM users WHERE email='$email'";  
        $result = $conn->query($sql);

        if($result == TRUE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->name = $row['name'];
            $loadedUser->email = $row['email'];
            $loadedUser->password = $row['password'];
            $loadedUser->address = $row['address'];

            return $loadedUser;
        }
        return NULL;
    }
    
    static public function loadAllUsers(mysqli $conn) {
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        $users = [];        
        
        if ($result == TRUE && $result->num_rows != 0) {
            foreach($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->name = $row['name'];
                $loadedUser->email = $row['email'];
                $loadedUser->password = $row['password'];
                $loadedUser->address = $row['address'];
                
                $users[] = $loadedUser;
            }
        }
        return $users;
    }
    
    public function delete(mysqli $conn) {

        if($this->id != -1) {
            $sql = "DELETE FROM users WHERE id=$this->id";
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