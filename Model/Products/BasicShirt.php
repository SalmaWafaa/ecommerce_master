<?php

require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\Product.php';

class BasicShirt extends Product {
    public function getSizeChart() {
        return "Shirt size chart: S, M, L, XL";
    }
}