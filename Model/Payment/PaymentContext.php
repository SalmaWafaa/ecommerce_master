<?php

class PaymentContext {
    private $strategy;

    public function __construct(PaymentStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function pay($amount) {
        return $this->strategy->pay($amount);
    }
}
