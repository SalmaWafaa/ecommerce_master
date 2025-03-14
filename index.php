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
            require_once $file;
            return;
        }
    }
    die("Class '{$class_name}' not found.");
});

// Database configuration
require_once  '/config/Database.php';

// Get the controller and action from the URL
$controller = $_GET['controller'] ?? 'Category'; // Default controller
$action = $_GET['action'] ?? 'listCategories';  // Default action

// Construct the controller class name
$controllerClassName = ucfirst($controller) . 'Controller';

try {
    // Check if the controller class exists
    if (!class_exists($controllerClassName)) {
        throw new Exception("Controller '{$controllerClassName}' not found.");
    }

    // Instantiate the controller
    $controllerInstance = new $controllerClassName();

    // Check if the action method exists in the controller
    if (!method_exists($controllerInstance, $action)) {
        throw new Exception("Action '{$action}' not found in controller '{$controllerClassName}'.");
    }

    // Prepare parameters for the action method
    $params = [];

    // If the action is 'updateProduct', include $_POST data
    if ($action === 'updateProduct') {
        $params = [$_GET['id'] ?? null, $_POST];
    } else {
        // For other actions, pass only the relevant GET parameters
        $params = array_filter($_GET, function($key) {
            return $key !== 'controller' && $key !== 'action';
        }, ARRAY_FILTER_USE_KEY);
    }

    // Call the action method with the prepared parameters
    call_user_func_array([$controllerInstance, $action], $params);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}