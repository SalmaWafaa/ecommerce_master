<?php
define('ROOT', 'C:\xampp\htdocs\ecommerce_master\\');

// require_once '../Model/OrderModel.php';
// require_once '../Model/CreditCardPayment.php';
// // require_once '../Model/PayPalPayment.php';
// require_once '../Model/bankTransferpayment.php';
require_once(ROOT . "Model/OrderModel.php");
require_once(ROOT . "Model/CreditCardPayment.php");
require_once(ROOT . "Model/BankTransferPayment.php");


class OrderController {
    public function checkout() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $amount = $_POST["amount"];
            $paymentType = $_POST["payment_method"];

            switch ($paymentType) {
                case "credit_card":
                    $paymentMethod = new CreditCardPayment();
                    break;
                
                case "bank_transfer":
                    $paymentMethod = new BankTransferPayment();
                    break;
                default:
                    die("Invalid payment method.");
            }

            $order = new Order($paymentMethod);
            $order->processPayment($amount);
        }
    }
}

$controller = new OrderController();
$controller->checkout();
?>
