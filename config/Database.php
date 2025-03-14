<?php

class Database{
    private static $instance = null;
    private $connection;

    public function __construct() {
        $this->connection = new mysqli("localhost", "root", "", "sweproj");

        if ($this->connection->connect_error) {
            throw new Exception("Database Connection Failed: " . $this->connection->connect_error);
        }

        // Set character encoding
        if (!$this->connection->set_charset("utf8mb4")) {
            throw new Exception("Error setting character encoding: " . $this->connection->error);
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
            $this->connection = null;
            self::$instance = null;
        }
    }

    private function __clone() {}
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}