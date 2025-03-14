<?php

require_once 'E:\xampp\htdocs\ecommerce_master\config\Database.php';
require_once 'E:\xampp\htdocs\ecommerce_master\Model\UserFactory.php';

class UserController {
    private $db;
    private $userFactory;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userFactory = new UserFactory();
    }
    public function register($type, $firstName, $lastName, $email, $password) {
        // Check if the email already exists
        $query = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            // Email already exists
            return "Email already registered. Please use a different email.";
        }
    
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        // Map user type to user_type_id
        $userTypeId = ($type == 'admin') ? 1 : 2; // Assuming 1 is for admin and 2 is for customer
    
        // Save the user to the database
        $query = "INSERT INTO users (first_name, last_name, email, password, user_type_id) VALUES (:firstName, :lastName, :email, :password, :userTypeId)";
        $stmt = $this->db->prepare($query);
    
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':userTypeId', $userTypeId);
    
        if ($stmt->execute()) {
            // Redirect to home.php after successful registration
            header("Location: home.php");
            exit(); // Ensure no further code is executed
        } else {
            // Print SQL error for debugging
            $errorInfo = $stmt->errorInfo();
            return "SQL Error: " . $errorInfo[2]; // Debugging statement
        }
    }

    public function login($email, $password) {
        // Fetch user from the database
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                // Create the appropriate user object
                $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
                $user = $this->userFactory->createUser($userType, $row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);
    
                // Store user details in the session
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_type'] = $userType;
                $_SESSION['email'] = $row['email'];
    
                // Redirect to home.php after successful login
                header("Location: home.php");
                exit(); // Ensure no further code is executed
            }
        }
    
        return "Invalid email or password.";
    }
    

    public function editAccount($userId, $firstName, $lastName, $email, $password) {
        // Fetch user from the database
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
            $user = $this->userFactory->createUser($userType, $row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);

            // Update user details
            $user->editAccount();
            return true;
        }

        return false;
    }
}