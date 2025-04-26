<?php
require_once __DIR__ . '/../config/dbConnectionSingelton.php';
require_once __DIR__ . '/../Model/User/UserFactory.php';
require_once __DIR__ . '/../View/User/EditProfileView.php';

class UserController {
    private $db;

    public function __construct() {
        // Initialize the database connection
        $this->db = Database::getInstance()->getConnection(); // Assuming the Database class has a method to get the connection.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function isAdmin() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in and has admin privileges
        return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
    }


    public function logout() {
        // Clear all session variables
        $_SESSION = array();
        
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        // Destroy the session
        session_destroy();
        
        // Redirect to homepage
        header("Location: /ecommerce_master/index.php");
        exit();
    }
    
    public function register($type, $firstName, $lastName, $email, $password) {
        // Check if email already exists
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
             error_log("Prepare failed (email check): " . $this->db->errorInfo()[2]);
             return "Registration failed due to a server error (DB prepare).";
        }
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            return "Email already registered. Please use a different email.";
        }
        
        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if ($hashedPassword === false) {
             error_log("Password hashing failed.");
             return "Registration failed due to a server error (Hashing).";
        }
        
        // Map user type string ('admin' or 'customer') to user_type_id (e.g., 1 or 2)
        // Adjust these IDs based on your actual database schema
        $userTypeId = ($type == 'admin') ? 1 : 2; 
        
        // Prepare insert statement
        $query = "INSERT INTO users (first_name, last_name, email, password, user_type_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
         if (!$stmt) {
             error_log("Prepare failed (insert): " . $this->db->errorInfo()[2]);
             return "Registration failed due to a server error (DB prepare insert).";
        }
        
        // Execute the insert statement
        if ($stmt->execute([$firstName, $lastName, $email, $hashedPassword, $userTypeId])) {
            // Return true on successful insertion
            return true; 
        } else {
            // Log the detailed SQL error and return a user-friendly message
            error_log("SQL Error in registration: " . implode(", ", $stmt->errorInfo())); 
            return "Registration failed due to a server error (DB execute). Please try again later.";
        }
    }
    
    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row && password_verify($password, $row['password'])) {
            $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
            
            // Set session variables after successful login
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = $userType;
            $_SESSION['first_name'] = $row['first_name'];  // Set the first name in the session
            $_SESSION['email'] = $row['email'];
    
            header("Location: ../index.php");  // Redirect to the homepage
            exit();
        }
    
        return "Invalid email or password.";
    }
    
    public function handleLoginRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $return_url = $_POST['return_url'] ?? '/ecommerce_master/index.php';
    
            $result = $this->login($email, $password);
    
            if ($result === true) {
                header("Location: " . $return_url);
                exit();
            } else {
                echo "Login failed: " . $result;
            }
        }
    }

    public function handleRegistrationRequest() {
        // Only proceed for POST requests
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Ensure session is started to store error messages or login state
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Get and sanitize input data (use default 'customer' if type isn't set)
            $type = $_POST['type'] ?? 'customer'; 
            $firstName = trim($_POST['firstName'] ?? '');
            $lastName = trim($_POST['lastName'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? ''; // Don't trim password

            // --- Basic Server-Side Validation ---
            $errors = [];
            if (empty($firstName)) { $errors[] = "First name is required."; }
            if (empty($lastName)) { $errors[] = "Last name is required."; }
            if (empty($email)) { 
                $errors[] = "Email is required."; 
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }
            if (empty($password)) { 
                $errors[] = "Password is required."; 
            } elseif (strlen($password) < 8) { // Match HTML pattern
                $errors[] = "Password must be at least 8 characters long.";
            }
            
            // If validation errors exist, store them and redirect back
            if (!empty($errors)) {
                 $_SESSION['register_error'] = implode("<br>", $errors);
                 // Adjust path if your register form is not in ../View/
                 header("Location: ../View/User/register.php"); 
                 exit();
            }
            // --- End Validation ---


            // Call the register method
            $result = $this->register($type, $firstName, $lastName, $email, $password);

            // Check the result from the register method
            if ($result === true) { 
                // Registration successful! Attempt to log the user in automatically.
                // The login() method should handle the session setup and redirect on success.
                $loginResult = $this->login($email, $password); 
                
                // If login() successfully redirects, the script execution stops there.
                // If login() fails *after* successful registration, it should return an error message.
                if ($loginResult !== true) { 
                    // Auto-login failed. Redirect to login page with a message.
                    if (session_status() == PHP_SESSION_NONE) { session_start(); } 
                    // Use login_error or a general message key
                    $_SESSION['login_error'] = "Registration successful, but auto-login failed. Please log in manually. " . ($loginResult ?: ''); 
                    // Adjust path if your login form is not in ../View/
                    header("Location: ../View/User/login.php"); 
                    exit();
                }
                // If login() returned true but didn't redirect (unlikely based on your code), redirect now:
                // header("Location: ../index.php"); // Adjust path if needed
                // exit();

            } else {
                // Registration failed: $result contains the error message from register()
                if (session_status() == PHP_SESSION_NONE) { session_start(); } 
                $_SESSION['register_error'] = $result; 
                // Redirect back to the registration page to display the error
                // Adjust path if your register form is not in ../View/
                header("Location: ../View/User/register.php"); 
                exit();
            }
        } else {
            // If accessed via GET, just redirect to the registration form page
            // Adjust path if your register form is not in ../View/
            header("Location: ../View/User/register.php"); 
            exit();
        }
    } 

    public function isLoggedIn() {
        // Example logic to check if a user is logged in
        return isset($_SESSION['user_id']);
    }


    public function editProfile($error = null) {
        // Ensure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: /View/User/login.php");
            exit();
        }
    
        $userId = $_SESSION['user_id'];
    
        try {
            // Fetch user from the database
            $query = "SELECT * FROM users WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$userId]);
    
            // Fetch the result as an associative array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Check if a user was found
            if ($row) {
                // Determine the user type
                $userType = ($row['user_type_id'] == 1) ? 'admin' : 'customer';
    
                // Create the user object using the UserFactory
                $user = UserFactory::createUser(
                    $userType,
                    $row['id'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['email'],
                    $row['password']
                );
    
                // Render the EditProfile view with the user data
                $view = new EditProfileView();
                $view->render($user, $error);
                exit(); // Ensure no further processing after rendering the view
            } else {
                // If no user was found, redirect to the home page
                header("Location: /index.php");
                exit();
            }
        } catch (PDOException $e) {
            // Handle errors (log them or display a generic message)
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../View/login.php");
            exit();
        }
    
        $userId = $_SESSION['user_id'];
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
    
        // Validate inputs
        if (empty($firstName) || empty($lastName) || empty($email)) {
            $this->editProfile("All fields except password are required.");
            return;
        }
    
        try {
            // Check if email is already taken
            $query = "SELECT id FROM users WHERE email = ? AND id != ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email, $userId]);
            
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->editProfile("Email address is already taken by another user.");
                return;
            }
    
            // Update user data
            if (empty($password)) {
                $query = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$firstName, $lastName, $email, $userId]);
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $userId]);
            }
    
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $firstName;
            
            // Use relative path for redirection
            header("Location: ../index.php");
            exit();
    
        } catch (PDOException $e) {
            $this->editProfile("An error occurred while updating your profile. Please try again.");
        }
    }

}
// Handle logout action
if (isset($_GET['action'])) {
    $controller = new UserController();

    switch ($_GET['action']) {
        case 'register':
            $controller->handleRegistrationRequest();
            break;
        case 'login':
            $controller->handleLoginRequest();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'editProfile':
            $controller->editProfile();
            break;
        case 'updateProfile':
            $controller->updateProfile();
            break;
        default:
            header("Location: /ecommerce_master/index.php");
            exit();
    }
}
?>
