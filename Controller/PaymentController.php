<?php

require_once 'Model/PaymentModel.php';
require_once 'Model/PaymentContext.php';
require_once 'Model/creditcardpayment.php';
require_once 'Model/bankTransferPayment.php';

class PaymentController
{
    public function showPaymentForm()
    {
        include 'View/paymentView.php';
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

            $paymentModel = new PaymentModel();
            $result = $paymentModel->savePayment($orderId, $billingAddressId, ucfirst($method), 'Paid', $transactionId, $amount);

            echo "<h3>Payment successful: $result</h3>";
        } else {
            header("Location: index.php?controller=Payment&action=showPaymentForm");
        }
    }
}
