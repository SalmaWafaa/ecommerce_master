

<?php

// Autoload classes
spl_autoload_register(function ($class_name) {
    $directories = [
        'C:/xampp/htdocs/ecommerce_master/Controller/',
        'C:/xampp/htdocs/ecommerce_master/Model/Products/'
    ];

    $class_name = str_replace('\\', '/', $class_name);

    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            include $file;
            return;
        }
    }

    throw new Exception("Class {$class_name} not found in Controller or Model directories.");
});

// Database configuration
require_once 'C:/xampp/htdocs/ecommerce_master/config/Database.php';

// Get the controller and action from the URL
$controller = $_GET['controller'] ?? 'Category'; // Default controller is 'Category'
$action = $_GET['action'] ?? 'listCategories';  // Default action is 'listCategories'

// Construct the controller class name
$controllerClassName = ucfirst($controller) . 'Controller';

// Check if the controller class exists
if (class_exists($controllerClassName)) {
    // Instantiate the controller
    $controllerInstance = new $controllerClassName();

    // Check if the action method exists in the controller
    if (method_exists($controllerInstance, $action)) {
        // Call the action method
        if (isset($_GET['subcategory_id'])) {
            // Pass the subcategory_id parameter if it exists
            $controllerInstance->$action($_GET['subcategory_id']);
        } elseif (isset($_GET['id'])) {
            // Pass the ID parameter if it exists
            $controllerInstance->$action($_GET['id']);
        } else {
            // Call the action without parameters
            $controllerInstance->$action();
        }
    } else {
        // Handle invalid action
        die("Action '$action' not found in controller '$controllerClassName'.");
    }
} else {
    // Handle invalid controller
    die("Controller '$controllerClassName' not found.");
}
require_once __DIR__ . '/Controller/OrderController.php';

$orderId = 1; // Assume order ID is 1 for testing
$controller = new OrderController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<pre>DEBUG: Form submitted!</pre>";
    $paymentMethod = $_POST['payment_type'];
    $controller->processPayment($orderId, $paymentMethod);
}

?>