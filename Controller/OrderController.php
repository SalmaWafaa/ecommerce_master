<?php
define('ROOT', 'C:\xampp\htdocs\ecommerce_master\\');

// require_once '../Model/OrderModel.php';
// require_once '../Model/CreditCardPayment.php';
// // require_once '../Model/PayPalPayment.php';
// require_once '../Model/bankTransferpayment.php';
// require_once(ROOT . "Model/OrderModel.php");
// require_once(ROOT . "Model/CreditCardPayment.php");
// require_once(ROOT . "Model/BankTransferPayment.php");
require_once 'E:\xampp\htdocs\ecommerce_master\Model\creditcardpayment.php';
require_once 'E:\xampp\htdocs\ecommerce_master\Model\bankTransferpayment.php';
require_once 'E:\xampp\htdocs\ecommerce_master\Model\OrderModel.php';
require_once 'E:\xampp\htdocs\ecommerce_master\Model\Order.php';
require_once 'E:\xampp\htdocs\ecommerce_master\Model\InventoryCheck.php';
require_once 'E:\xampp\htdocs\ecommerce_master\Model\Shipping.php';

class OrderController 
{
    public function checkout() 
    {
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


//     public function createOrder($id, $items, $dateCreated, $shipmentDate, $total, $status, $address, $paymentType)
//     {
//        $order = new Order($id, $items, $dateCreated, $shipmentDate, $total, $status, $address, $paymentType);

//        // Attach observers
//        $inventoryCheck = new InventoryCheck();
//        $shipping = new Shipping();
//        $order->attach($inventoryCheck);
//        $order->attach($shipping);

//        // Place the order
//        $order->placeOrder();
//    }
}

$controller = new OrderController();
$controller->checkout();
?>


