<?php

require_once 'C:\xampp\htdocs\ecommerce_master\config\Database.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\UserFactory.php';

class UserController {
    private $db;
    private $userFactory;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
        $this->userFactory = new UserFactory();

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register($type, $firstName, $lastName, $email, $password) {
        // Validate input
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            return "All fields are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        // Check if the email already exists
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return "Email already registered. Please use a different email.";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Map user type to user_type_id
        $userTypeId = ($type == 'admin') ? 1 : 2; // Assuming 1 is for admin and 2 is for customer

        // Save the user to the database
        $query = "INSERT INTO users (first_name, last_name, email, password, user_type_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $userTypeId);

        if ($stmt->execute()) {
            // Redirect to home.php after successful registration
            header("Location: /ecommerce_master/categories/category_list.php");
            exit();
        } else {
            return "SQL Error: " . $stmt->error;
        }
    }

    public function login($email, $password) {
        // Validate input
        if (empty($email) || empty($password)) {
            return "Email and password are required.";
        }

        // Fetch user from the database
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Create the appropriate user object
                $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
                $user = $this->userFactory->createUser($userType, $row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);

                // Store user details in the session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_type'] = $userType;
                $_SESSION['email'] = $row['email'];

                // Redirect to home.php after successful login
                header("Location: /ecommerce_master/categories/category_list.php");
                exit();
            }
        }

        return "Invalid email or password.";
    }

    public function logout() {
        // Destroy the session
        session_unset();
        session_destroy();

        // Redirect to the login page
        header("Location: /ecommerce_master/View/login.php");
        exit();
    }

    public function editAccount($userId, $firstName, $lastName, $email, $password) {
        // Validate input
        if (empty($firstName) || empty($lastName) || empty($email)) {
            return "All fields are required.";
        }

        // Fetch user from the database
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
            $user = $this->userFactory->createUser($userType, $row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);

            // Update user details
            $user->editAccount();
            return true;
        }

        return false;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUserType() {
        return $_SESSION['user_type'] ?? null;
    }
}