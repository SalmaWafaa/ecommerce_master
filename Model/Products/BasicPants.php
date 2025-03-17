<?php

require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\Product.php';

class BasicPants extends Product {
    public function getSizeChart() {
        return "Pants size chart: 28, 30, 32, 34";
    }
}