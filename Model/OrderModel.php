<?php
require_once 'PaymentStrategy.php';

class Order {
    private $paymentMethod;

    public function __construct(PaymentStrategy $paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function processPayment($amount) {
        $this->paymentMethod->pay($amount);
    }
}
?>
