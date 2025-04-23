<<<<<<< HEAD
<?php
// Start the session
session_start();

// Include the UserController class
// require_once __DIR__ . '/../../Controller/UserController.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Controller\UserController.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create a UserController object
    $userController = new UserController();

    // Attempt to register the user
    $result = $userController->register($type, $firstName, $lastName, $email, $password);

    if ($result === true) {
        // Registration successful, redirect to home.php
        header("index.php");
        exit();
    } else {
        // Display the error message
        echo "Registration failed: " . $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
=======
        <!DOCTYPE html>
        <html>
        <head>
            <title>Register</title>
            <style>
>>>>>>> a7ff493ccf16dd71beed32ca7dc8994bf1c18bce
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .register-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .register-form input {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .register-form button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .register-form button:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
        </head>
        <body>
            <div class="register-form">
                <h2>Register</h2>
                <form action="../Controller/UserController.php?action=register" method="POST">
                    <select name="type">
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                    <input type="text" name="firstName" placeholder="First Name"required>
                    <input type="text" name="lastName" placeholder="Last Name"required>
                    <input type="email" name="email" placeholder="Email"required>
                    <input type="password" name="password" placeholder="Password"required>
                    <button type="submit">Register</button>
                </form>
                <p style="text-align: center; margin-top: 10px;">
                Already have an account?  <a href="?controller=User&action=showLogin">Login</a>
            </div>
        </body>
        </html>
