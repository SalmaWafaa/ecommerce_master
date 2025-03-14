

<?php
require_once __DIR__ . '/Controller/OrderController.php';

$orderId = 1; // Assume order ID is 1 for testing
$controller = new OrderController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<pre>DEBUG: Form submitted!</pre>";
    $paymentMethod = $_POST['payment_type'];
    $controller->processPayment($orderId, $paymentMethod);
}

?>