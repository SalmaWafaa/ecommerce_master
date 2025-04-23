<?php

require_once __DIR__ . '/../../config/dbConnectionSingelton.php';

abstract class ProductFactory {
    protected $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    abstract public function createProduct($data);
}