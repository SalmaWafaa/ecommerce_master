<?php
//require_once __DIR__ . '/Controller/homecontroller.php';


//$controller = new HomeController();
//$controller->index();



// Autoload classes (if using Composer or PSR-4 autoloading)
// require 'vendor/autoload.php';

require_once 'C:\xampp\htdocs\ecommerce_master\Controller\CategoryController.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Controller\ProductController.php';

$action = $_GET['action'] ?? 'listMainCategories';
$controllerInstance = new CategoryController();
$controllerInstance->$action($_GET['id'] ?? null);
?>
