<?php


//namespace Controllers;
require_once __DIR__ . '/../Model/Products/BasicTshirt.php';
require_once __DIR__ . '/../Model/Products/ShortSleeveTshirt.php';
class ProductController {
    public function testProducts() {
        // Create a BasicTshirt object
        $basicTshirt = new BasicTshirt(
            1,
            "Basic Tshirt",
            ["Red", "Blue"],
            ["S", "M"],
            ["img1.jpg"],
            4.5,
            [],
            100,
            10,
            29.99
        );

        echo $basicTshirt->getDescription() . "\n"; // Output: This is a basic t-shirt.
        echo "Price: $" . $basicTshirt->getPrice() . "\n"; // Output: Calculated price after discount

        // Create a ShortSleeveTshirt object
        $shortSleeveTshirt = new ShortSleeveTshirt(
            2,
            "Short Sleeve Tshirt",
            ["Green", "Yellow"],
            ["M", "L"],
            ["img2.jpg"],
            4.7,
            [],
            50,
            5,
            19.99
        );

        echo $shortSleeveTshirt->getDescription() . "\n"; // Output: This is a short-sleeve t-shirt.
        echo "Price: $" . $shortSleeveTshirt->getPrice() . "\n"; // Output: Calculated price after discount
    }
}