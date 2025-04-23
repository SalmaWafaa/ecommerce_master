<?php

//require_once 'C:\xampp\htdocs\ecommerce_master\config\Database.php';
//require_once 'C:\xampp\htdocs\ecommerce_master\Model\UserFactory.php';
require_once __DIR__ . '/../config/dbConnectionSingelton.php';

require_once 'C:\xampp\htdocs\ecommerce_master\Model\UserFactory.php';

class UserController {
    private $db;
    private $userFactory;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        $this->userFactory = new UserFactory();
    }

    public function register($type, $firstName, $lastName, $email, $password) {
        // Check if the email already exists
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
    
        if ($stmt->rowCount() > 0) {
            return "Email already registered. Please use a different email.";
        }
    
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        // Map user type to user_type_id
        $userTypeId = ($type == 'admin') ? 1 : 2;
    
        // Save the user to the database
        $query = "INSERT INTO users (first_name, last_name, email, password, user_type_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        if ($stmt->execute([$firstName, $lastName, $email, $hashedPassword, $userTypeId])) {
            header("Location: ../index.php");
            exit();
        } else {
            return "SQL Error: " . implode(", ", $stmt->errorInfo());
        }
    }
    

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row && password_verify($password, $row['password'])) {
            $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
            $user = $this->userFactory->createUser($userType, $row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);
    
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = $userType;
            $_SESSION['email'] = $row['email'];
    
            header("Location: ../index.php");
            exit();
        }
    
        return "Invalid email or password.";
    }
    
    public function editAccount($userId, $firstName, $lastName, $email, $password) {
        // Fetch user from the database
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        // if ($result->num_rows > 0) {
        //     $row = $result->fetch_assoc();
        //     $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
        //     $user = $this->userFactory->createUser($userType, $row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);

        //     // Update user details
        //     $user->editAccount();
        //     return true;
        // }

        return false;
    }
}