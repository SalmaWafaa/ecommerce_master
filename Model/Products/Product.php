<?php

require_once __DIR__ . '/../../config/dbConnectionSingelton.php';

class Product {
    protected $conn;
    protected $table = 'products';

    // Product properties
    public $id;
    public $name;
    public $category_id;
    public $product_type_id;
    public $description;
    public $price;
    public $on_sale;
    public $rate;
    public $quantity;

    // Constructor with database connection
    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();

        // Initialize properties if data is provided
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? '';
            $this->category_id = $data['category_id'] ?? '';
            $this->product_type_id = $data['product_type_id'] ?? '';
            $this->description = $data['description'] ?? '';
            $this->price = $data['price'] ?? 0;
            $this->on_sale = $data['on_sale'] ?? 0;
            $this->rate = $data['rate'] ?? 0;
            $this->quantity = $data['quantity'] ?? 0;
        }
    }

    // Create a new product
    public function create() {
        // Check if the category_id exists
        $query = "SELECT id FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $this->category_id, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() === 0) {
            throw new Exception("Invalid category_id: Category does not exist.");
        }
        $stmt->closeCursor(); // Close cursor after checking
    
        // Check if the product_type_id exists
        $query = "SELECT id FROM producttypes WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $this->product_type_id, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() === 0) {
            throw new Exception("Invalid product_type_id: Product type does not exist.");
        }
        $stmt->closeCursor(); // Close cursor after checking
    
        // Insert the product
        $query = "INSERT INTO {$this->table} 
                  (name, category_id, product_type_id, description, price, on_sale, rate, quantity) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $this->name, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->category_id, PDO::PARAM_INT);
        $stmt->bindValue(3, $this->product_type_id, PDO::PARAM_INT);
        $stmt->bindValue(4, $this->description, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->price, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->on_sale, PDO::PARAM_BOOL);
        $stmt->bindValue(7, $this->rate, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->quantity, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    // Read all products
    public function read() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }

    // Read a single product by ID
    public function readOne($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    }

    // Update a product
    public function update() {
        $query = "UPDATE {$this->table} 
                  SET name = ?, category_id = ?, product_type_id = ?, 
                      description = ?, price = ?, on_sale = ?, 
                      rate = ?, quantity = ? 
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $this->name, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->category_id, PDO::PARAM_INT);
        $stmt->bindValue(3, $this->product_type_id, PDO::PARAM_INT);
        $stmt->bindValue(4, $this->description, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->price, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->on_sale, PDO::PARAM_BOOL);
        $stmt->bindValue(7, $this->rate, PDO::PARAM_STR);
        $stmt->bindValue(8, $this->quantity, PDO::PARAM_INT);
        $stmt->bindValue(9, $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->closeCursor();
            return true;
        }

        $stmt->closeCursor();
        return false;
    }

    // Delete a product
    // Duplicate delete method removed.

    // Get products by category ID
    public function getProductsByCategory($category_id) {
        $query = "SELECT * FROM {$this->table} WHERE category_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $products;
    }
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $this->id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            $stmt->closeCursor();
            return true;
        }
    
        $stmt->closeCursor();
        return false;
    }
    // Get size chart (default implementation)
    public function getSizeChart() {
        return "Default size chart";
    }
}
