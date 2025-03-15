<?php

require_once './Controller/CartController.php';
require_once './View/CartView.php';

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer_id'] = 1; // Example: Assign a dummy customer ID for testing
}

$cartController = new CartController();
$cartView = new CartView($cartController);

$cartView->renderCart();

?>
