<?php

// abstract class User {
//     protected $id;
//     protected $firstName;
//     protected $lastName;
//     protected $email;
//     protected $password;

//     public function __construct($id, $firstName, $lastName, $email, $password) {
//         $this->id = $id;
//         $this->firstName = $firstName;
//         $this->lastName = $lastName;
//         $this->email = $email;
//         $this->password = $password;
//     }

//     // Setter for ID
//     public function setId($id) {
//         $this->id = $id;
//     }

//     // Getter for ID
//     public function getId() {
//         return $this->id;
//     }

//     // Setter for first name
//     public function setFirstName($firstName) {
//         $this->firstName = $firstName;
//     }

//     // Setter for last name
//     public function setLastName($lastName) {
//         $this->lastName = $lastName;
//     }

//     // Setter for email
//     public function setEmail($email) {
//         $this->email = $email;
//     }

//     // Setter for password
//     public function setPassword($password) {
//         $this->password = $password;
//     }

//     abstract public function login();
//     abstract public function register();
//     abstract public function editAccount();
// }

require_once __DIR__ . '/../config/dbConnectionSingelton.php';
abstract class User {
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $password;

    public function __construct($id, $firstName, $lastName, $email, $password) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    // Setter for ID
    public function setId($id) 
    {
        if (!is_numeric($id)) {
            throw new Exception("ID must be a number");
        }
        if ($id < 0) {
            throw new Exception("ID must be a positive number");
        }
        $this->id = $id;
    }

    // Getter for ID
    public function getId() {
        return $this->id;
    }

    // Setter for first name
    public function setFirstName($firstName) {
        if (strlen($firstName) < 2) {
            throw new Exception("First name must be at least 2 characters long");
        }
        $this->firstName = $firstName;
    }

    // Setter for last name
    public function setLastName($lastName) {
        if (strlen($lastName) < 2) {
            throw new Exception("Last name must be at least 2 characters long");
        }
        $this->lastName = $lastName;
    }

    // Setter for email
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }
        $this->email = $email;
    }

    // Setter for password
    public function setPassword($password) {
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long");
        }
        $this->password = $password;
    }

    abstract public function login();
    abstract public function register();
    abstract public function editAccount();
}
// abstract class User {
//     protected $id;
//     protected $firstName;
//     protected $lastName;
//     protected $email;
//     protected $password;
//     protected $db;

//     public function __construct($id, $firstName, $lastName, $email, $password) {
//         $this->id = $id;
//         $this->firstName = $firstName;
//         $this->lastName = $lastName;
//         $this->email = $email;
//         $this->password = $password;
        
//         $database = Database::getInstance();
//         $this->db = $database->getConnection();
//     }

//     // Common getters
//     public function getId() { return $this->id; }
//     public function getFirstName() { return $this->firstName; }
//     public function getLastName() { return $this->lastName; }
//     public function getEmail() { return $this->email; }

//     // Common setters
//     public function setFirstName($firstName) 
//     { 
//         $this->firstName = $firstName; 
//     }
//     public function setLastName($lastName) { $this->lastName = $lastName; }
//     public function setEmail($email) { $this->email = $email; }
//     public function setPassword($password) { $this->password = $password; }

//     // Abstract methods each user type must implement
//     abstract public function login();
//     abstract public function register();
//     abstract public function editAccount();
// }
?>