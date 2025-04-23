<?php
class Database {
    private static $instance = null;
    private $connection;

<<<<<<< HEAD
    private $host = 'localhost';
    private $dbname = 'swe_master';
    private $username = 'root';
    private $password = '';
=======
    private function __construct() {
        $this->connection = new mysqli("localhost", "root", "", "swe_master");
        
        if ($this->connection->connect_error) {
            throw new Exception("Database Connection Failed: " . $this->connection->connect_error);
        }
>>>>>>> a7ff493ccf16dd71beed32ca7dc8994bf1c18bce

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", 
                                         $this->username, 
                                         $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>
