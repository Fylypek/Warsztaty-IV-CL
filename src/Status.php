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
    
}

?>