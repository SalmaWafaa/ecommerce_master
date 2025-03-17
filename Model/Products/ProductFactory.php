<?php

require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\Product.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\BasicShirt.php';
require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\BasicPants.php';

class ProductFactory {
    public static function createProduct($data) {
        switch ($data['product_type_id']) {
            case 1: // Assuming 1 is the ID for BasicShirt
                return new BasicShirt($data);
            case 2: // Assuming 2 is the ID for BasicPants
                return new BasicPants($data);
            default:
                return new Product($data); // Fallback to base Product class
        }
    }
}