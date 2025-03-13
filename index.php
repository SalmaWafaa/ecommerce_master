<?php
require_once __DIR__ . '/Controller/OrderController.php';

require_once './View/paymentView.php';

$controller = new OrderController();
$controller->checkout();
?>
