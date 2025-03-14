<?php
//require_once __DIR__ . '/Controller/homecontroller.php';
require_once __DIR__ . '/Controller/OrderController.php';

require_once './View/paymentView.php';

//$controller = new HomeController();
//$controller->index();



// Autoload classes (if using Composer or PSR-4 autoloading)
// require 'vendor/autoload.php';

require_once 'C:\xampp\htdocs\ecommerce_master\Controller\CategoryController.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Controller\ProductController.php';

$action = $_GET['action'] ?? 'listMainCategories';
$controllerInstance = new CategoryController();
$controllerInstance->$action($_GET['id'] ?? null);
//$controller = new OrderController();
//$controller->checkout();



?>

