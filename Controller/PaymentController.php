<?php

require_once 'Model/Payment/PaymentModel.php';
require_once 'Model/Payment/PaymentContext.php';
require_once 'Model/Payment/creditcardpayment.php';
require_once 'Model/Payment/bankTransferPayment.php';

class PaymentController
{
    public function showPaymentForm()
    {
        include 'View/Payment/paymentView.php';
    }

    public function handlePayment()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $method = $_POST['method'];
        $amount = $_POST['amount'];

        // Dummy data (replace with session/cart/order retrieval)
        $orderId = 1;
        $billingAddressId = 1;

        switch ($method) {
            case 'credit':
                $strategy = new CreditCardPayment();
                break;
            // case 'paypal':
            //     $strategy = new PayPalStrategy();
            //     break;
            case 'cash':
                $strategy = new BankTransferPayment();
                break;
            default:
                die("Invalid payment method.");
        }

        $paymentContext = new PaymentContext($strategy);
        $transactionId = $paymentContext->pay($amount);

        // Add payment status and code based on the method
        $paymentStatus = 'Paid'; // You can change this logic based on conditions
        $paymentCode = $transactionId; // Assuming transactionId is the payment code

        $paymentModel = new PaymentModel();
        $result = $paymentModel->savePayment($orderId, $billingAddressId, ucfirst($method), $paymentStatus, $paymentCode, $amount);

        if ($result) {
            echo "<h3>Payment successful: Transaction ID - $transactionId</h3>";
        } else {
            echo "<h3>Payment failed</h3>";
        }
    } else {
        header("Location: index.php?controller=Payment&action=showPaymentForm");
    }
}

}
