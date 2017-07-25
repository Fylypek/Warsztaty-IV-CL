<?php

class Db extends PDO{
    
    public function __construct() {
        $config = [
            'db_type' => 'mysql',
            'db_name' => 'workshop4',
            'db_user' => 'root',
            'db_pass' => 'coderslab',
            'charset' => 'utf8',
            'host' => 'localhost'
        ];
        parent::__construct("{$config['db_type']}:host={$config['host']};dbname={$config['db_name']}",
            $config['db_user'], $config['db_pass'],
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['charset']}"));
    }
}
$dd = new Db();
var_dump($dd);