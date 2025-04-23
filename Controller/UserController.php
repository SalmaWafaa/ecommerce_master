<?php
require_once __DIR__ . '/../config/dbConnectionSingelton.php';
require_once __DIR__ . '/../Model/UserFactory.php';

class UserController {
    private $db;
    private $userFactory;

    public function __construct() {
        // Initialize the database connection
        $this->db = Database::getInstance()->getConnection(); // Assuming the Database class has a method to get the connection.
        $this->userFactory = new UserFactory(); // Assuming you want to initialize the userFactory.
    }
    

    public function register($type, $firstName, $lastName, $email, $password) {
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
    
    public function handleLoginRequest() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $result = $this->login($email, $password);
    
            if ($result === true) {
                header("Location: ../View/home.php");
                exit();
            } else {
                echo "Login failed: " . $result;
            }
        }
    }
    public function isLoggedIn() {
        // Example logic to check if a user is logged in
        return isset($_SESSION['user_id']);
    }
    
 
    public function handleRegistrationRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type = $_POST['type'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $result = $this->register($type, $firstName, $lastName, $email, $password);
    
            if ($result === true) {
                header("Location: ../View/home.php");
                exit();
            } else {
                echo "Registration failed: " . $result;
            }
        }
    }
    
    public function editAccount($userId, $firstName, $lastName, $email, $password) {
        // Validate input
        if (empty($firstName) || empty($lastName) || empty($email)) {
            return "All fields are required.";
        }

        // Fetch user from the database
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (isset($_GET['action'])) {
    $controller = new UserController();

    switch ($_GET['action']) {
        case 'register':
            $controller->handleRegistrationRequest();
            break;
        case 'login':
            $controller->handleLoginRequest();
            break;
        default:
            echo "Invalid action.";
            break;
    }
}
