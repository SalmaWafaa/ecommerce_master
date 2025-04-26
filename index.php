<?php
// Autoload classes
spl_autoload_register(function ($class_name) {
    $directories = [
        __DIR__ . '/Controller/',
        __DIR__ . '/Model/Products/',
        __DIR__ . '/Controller/Cart/',
            
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
require_once __DIR__ . '/config/dbConnectionSingelton.php';

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

    // If the action is 'deleteProduct', pass the product ID
    if ($action === 'deleteProduct') {
        $params = [$_GET['id'] ?? null];
    } 
    // For user profile update
    elseif ($action === 'updateProfile') {
        $params = [$_POST];
    }
    // elseif ($action == 'viewProductDetails') {
    //     $id = $_GET['id'] ?? null;
    //     if ($id) {
    //         $controllerInstance = new ProductController();
    //         $controllerInstance->viewProductDetails($id);
    //     }
    // }
    else {
        // For other actions, pass only the relevant GET parameters
        $params = array_values(array_filter($_GET, function($key) {
            return $key !== 'controller' && $key !== 'action';
        }, ARRAY_FILTER_USE_KEY));
    }

    // Call the action method with the prepared parameters
    call_user_func_array([$controllerInstance, $action], $params);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
