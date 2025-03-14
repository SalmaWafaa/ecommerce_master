<?php

require_once 'User.php';

class Customer extends User {
    private $db;

    public function __construct($id, $firstName, $lastName, $email, $password) {
        parent::__construct($id, $firstName, $lastName, $email, $password);
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Implementation of abstract methods from the User class
    public function login() {
        // Check if the customer exists in the database
        $query = "SELECT * FROM users WHERE email = :email AND user_type_id = 2"; // Assuming 2 is the customer type
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                // Set customer details
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

        // Insert the customer into the database
        $query = "INSERT INTO users (first_name, last_name, email, password, user_type_id) VALUES (:firstName, :lastName, :email, :password, 2)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }


    // Method to fetch customer details by ID
    public function getCustomerById() {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update customer details
    public function editAccount() {
        $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, email = :email, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // public function editAccount() {
    //     // Update customer details in the database
    //     $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, email = :email WHERE id = :id";
    //     $stmt = $this->db->prepare($query);

    //     $stmt->bindParam(':firstName', $this->firstName);
    //     $stmt->bindParam(':lastName', $this->lastName);
    //     $stmt->bindParam(':email', $this->email);
    //     $stmt->bindParam(':id', $this->id);

    //     return $stmt->execute();
    // }

    

    // // Customer-specific methods
    // public function addOrder($order) {
    //     $query = "INSERT INTO orders (customer_id, total, status, address, payment_type) VALUES (:customer_id, :total, :status, :address, :payment_type)";
    //     $stmt = $this->db->prepare($query);

    //     $stmt->bindParam(':customer_id', $this->id);
    //     $stmt->bindParam(':total', $order['total']);
    //     $stmt->bindParam(':status', $order['status']);
    //     $stmt->bindParam(':address', $order['address']);
    //     $stmt->bindParam(':payment_type', $order['payment_type']);

    //     if ($stmt->execute()) {
    //         $orderId = $this->db->lastInsertId();

    //         // Add order items
    //         foreach ($order['items'] as $item) {
    //             $this->addOrderItem($orderId, $item['product_id'], $item['quantity']);
    //         }

    //         return $orderId;
    //     }

    //     return false;
    // }

    // private function addOrderItem($orderId, $productId, $quantity) {
    //     $query = "INSERT INTO orderitems (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
    //     $stmt = $this->db->prepare($query);

    //     $stmt->bindParam(':order_id', $orderId);
    //     $stmt->bindParam(':product_id', $productId);
    //     $stmt->bindParam(':quantity', $quantity);

    //     return $stmt->execute();
    // }

    // public function addToCart($productId, $quantity) {
    //     // Check if the customer already has a cart
    //     $cartId = $this->getCartId();

    //     if (!$cartId) {
    //         // Create a new cart for the customer
    //         $query = "INSERT INTO cart (customer_id) VALUES (:customer_id)";
    //         $stmt = $this->db->prepare($query);
    //         $stmt->bindParam(':customer_id', $this->id);
    //         $stmt->execute();
    //         $cartId = $this->db->lastInsertId();
    //     }

    //     // Add the product to the cart
    //     $query = "INSERT INTO cartitems (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity) ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
    //     $stmt = $this->db->prepare($query);

    //     $stmt->bindParam(':cart_id', $cartId);
    //     $stmt->bindParam(':product_id', $productId);
    //     $stmt->bindParam(':quantity', $quantity);

    //     return $stmt->execute();
    // }

    // private function getCartId() {
    //     $query = "SELECT id FROM cart WHERE customer_id = :customer_id";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindParam(':customer_id', $this->id);
    //     $stmt->execute();

    //     if ($stmt->rowCount() > 0) {
    //         $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $row['id'];
    //     }

    //     return false;
    // }

    // public function addToFavorites($productId) {
    //     $query = "INSERT INTO favorites (customer_id, product_id) VALUES (:customer_id, :product_id)";
    //     $stmt = $this->db->prepare($query);

    //     $stmt->bindParam(':customer_id', $this->id);
    //     $stmt->bindParam(':product_id', $productId);

    //     return $stmt->execute();
    // }

    // public function addReview($productId, $orderId, $rating, $comment) {
    //     $query = "INSERT INTO reviews (customer_id, product_id, order_id, rating, comment) VALUES (:customer_id, :product_id, :order_id, :rating, :comment)";
    //     $stmt = $this->db->prepare($query);

    //     $stmt->bindParam(':customer_id', $this->id);
    //     $stmt->bindParam(':product_id', $productId);
    //     $stmt->bindParam(':order_id', $orderId);
    //     $stmt->bindParam(':rating', $rating);
    //     $stmt->bindParam(':comment', $comment);

    //     return $stmt->execute();
    // }

    // public function viewOrderHistory() {
    //     $query = "SELECT * FROM orders WHERE customer_id = :customer_id";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindParam(':customer_id', $this->id);
    //     $stmt->execute();

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function contactUs($subject, $message) {
    //     $query = "INSERT INTO contactus (customer_id, subject, message) VALUES (:customer_id, :subject, :message)";
    //     $stmt = $this->db->prepare($query);

    //     $stmt->bindParam(':customer_id', $this->id);
    //     $stmt->bindParam(':subject', $subject);
    //     $stmt->bindParam(':message', $message);

    //     return $stmt->execute();
    // }
}