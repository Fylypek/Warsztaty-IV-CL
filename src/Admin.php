<?php

class Admin {
    private $id;
    private $email;
    private $password;
    
    function __construct() {
        $this->id = -1;
        $this->email = "";
        $this->password = "";
    }
    
    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $options = ['cost' => 11];
        $this->password = password_hash($password, PASSWORD_DEFAULT, $options);
    }

    public function saveToDB(mysqli $conn) {
        $id = $conn->real_escape_string($this->id);
        $email = $conn->real_escape_string($this->email);
        $password = $conn->real_escape_string($this->password);
        
        if($this->id == -1) {
            $sql = "INSERT INTO admins (email, password)
                VALUES ('$email', '$password')";
            $result = $conn->query($sql);

            if ($result == TRUE) {
                $this->id = $conn->insert_id;
                return TRUE;
            }
        } else {
            $sql = "UPDATE admins SET email='$email', password='$password',
                    WHERE id=$id";
            $result = $conn->query($sql);

            if($result == TRUE) {
                return TRUE;
            }
        }
        return FALSE;
    }
    
    static public function loadAdminByEmail(mysqli $conn, $email) {
        $email = $conn->real_escape_string($email);

        $sql = "SELECT * FROM admins WHERE email='$email'";
        $result = $conn->query($sql);
        echo $conn->error;
        if($result == TRUE && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $loadedAdmin = new Admin();
            $loadedAdmin->id = $row['id'];
            $loadedAdmin->email = $row['email'];
            $loadedAdmin->password = $row['password'];

            return $loadedAdmin;
        }    
        return NULL;
    }
}