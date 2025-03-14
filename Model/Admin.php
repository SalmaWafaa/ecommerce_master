<?php

require_once 'User.php';

class Admin extends User {
    private $db;

    public function __construct($id, $firstName, $lastName, $email, $password) {
        parent::__construct($id, $firstName, $lastName, $email, $password);
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Implementation of abstract methods from the User class
    public function login() {
        // Check if the admin exists in the database
        $query = "SELECT * FROM users WHERE email = :email AND user_type_id = 1"; // Assuming 1 is the admin type
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                // Set admin details
                $this->id = $row['id'];
                $this->firstName = $row['first_name'];
                $this->lastName = $row['last_name'];
                return true;
            }
        }
        return false;
    }

    public function register() {
        // Hash the password
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        // Insert the admin into the database
        $query = "INSERT INTO users (first_name, last_name, email, password, user_type_id) VALUES (:firstName, :lastName, :email, :password, 1)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    public function editAccount() {
        // Update admin details in the database
        $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Admin-specific methods
    public function addCategory($category) {
        $query = "INSERT INTO categories (name, image, parent_id) VALUES (:name, :image, :parent_id)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $category['name']);
        $stmt->bindParam(':image', $category['image']);
        $stmt->bindParam(':parent_id', $category['parent_id']);

        return $stmt->execute();
    }

    public function updateCategory($category) {
        $query = "UPDATE categories SET name = :name, image = :image, parent_id = :parent_id WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $category['name']);
        $stmt->bindParam(':image', $category['image']);
        $stmt->bindParam(':parent_id', $category['parent_id']);
        $stmt->bindParam(':id', $category['id']);

        return $stmt->execute();
    }

    public function deleteCategory($categoryId) {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $categoryId);

        return $stmt->execute();
    }

    public function addProduct($product) {
        $query = "INSERT INTO products (name, category_id, product_type_id, description, price, on_sale, rate, quantity) VALUES (:name, :category_id, :product_type_id, :description, :price, :on_sale, :rate, :quantity)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $product['name']);
        $stmt->bindParam(':category_id', $product['category_id']);
        $stmt->bindParam(':product_type_id', $product['product_type_id']);
        $stmt->bindParam(':description', $product['description']);
        $stmt->bindParam(':price', $product['price']);
        $stmt->bindParam(':on_sale', $product['on_sale']);
        $stmt->bindParam(':rate', $product['rate']);
        $stmt->bindParam(':quantity', $product['quantity']);

        return $stmt->execute();
    }

    public function updateProduct($product) {
        $query = "UPDATE products SET name = :name, category_id = :category_id, product_type_id = :product_type_id, description = :description, price = :price, on_sale = :on_sale, rate = :rate, quantity = :quantity WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $product['name']);
        $stmt->bindParam(':category_id', $product['category_id']);
        $stmt->bindParam(':product_type_id', $product['product_type_id']);
        $stmt->bindParam(':description', $product['description']);
        $stmt->bindParam(':price', $product['price']);
        $stmt->bindParam(':on_sale', $product['on_sale']);
        $stmt->bindParam(':rate', $product['rate']);
        $stmt->bindParam(':quantity', $product['quantity']);
        $stmt->bindParam(':id', $product['id']);

        return $stmt->execute();
    }

    public function deleteProduct($productId) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $productId);

        return $stmt->execute();
    }

    public function manageOrders() {
        // Fetch all orders from the database
        $query = "SELECT * FROM orders";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function respondToContactUs($messageId, $response) {
        // Update the contact message with a response
        $query = "UPDATE contactus SET response = :response WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':response', $response);
        $stmt->bindParam(':id', $messageId);

        return $stmt->execute();
    }
}