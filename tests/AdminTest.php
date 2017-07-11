<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/Admin.php';

class adminTest extends PHPUnit_Extensions_Database_TestCase {
    
    private static $conn;
    
    public function getConnection() {
        $conn = new PDO(
            $GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASSWD']
            );
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnections($conn, $GLOBALS['DB_NAME']);
    }
    
    public function getDataSet() {
        return $this->createFlatXmlDataSet(__DIR__.'/datasets/Admin.xml');
    }
    
    public static function setUpBeforeClass() {
        self::$conn = new mysqli('localhost',
                $GLOBALS['DB_USER'],
                $GLOBALS['DB_PASSWD'],
                $GLOBALS['DB_NAME']);
    }
    
    public static function tearDownAfterClass() {
        self::$conn->close();
    }
    
    public function testIfReturnsTrue() {
        $admin = new Admin();
        $admin->setEmail('test@test.pl');
        $admin->setPassword('qwerty');
        
        $this->assertTrue($admin->save(self::$conn));
    }
}

