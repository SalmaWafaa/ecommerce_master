<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Products</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-top: 30px;
        }

        /* Product grid layout */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        /* Product box styling */
        .product-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Hover effect for product boxes */
        .product-box:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        /* Product image styling */
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        /* Product name and description */
        .product-box h3 {
            color: #333;
            font-size: 20px;
            margin: 10px 0;
        }

        .product-box p {
            color: #555;
            font-size: 14px;
            margin: 5px 0;
            text-align: center;
        }

        .product-box p strong {
            font-weight: bold;
            color: #333;
        }

        /* Button styles */
        .product-box .add-to-cart-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .product-box .add-to-cart-link:hover {
            background-color: #218838;
        }

        /* No products found message */
        .no-products-message {
            color: #666;
            font-size: 18px;
            margin-top: 20px;
        }

        /* Feedback message styling */
        .feedback {
            padding: 10px 15px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        /* View Cart button styling */
        .view-cart-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            margin-top: 20px;
        }

        .view-cart-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Products in <?php echo htmlspecialchars($subcategory->getName()); ?></h1>

    <!-- Display any feedback messages -->
    <?php if (isset($message)): ?>
        <div class="feedback"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- Product grid -->
    <div class="product-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-box">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                    <!-- Correct Add to Cart navigation link -->
                    <a href="Controller/Cart/AddtoCart.php?product_id=<?= $product['id']; ?>" class="add-to-cart-link">Add to Cart</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-products-message">No products found in this subcategory.</p>
        <?php endif; ?>
    </div>

    <!-- View Cart Button -->
    <div class="actions">
        <a href="index.php?controller=RCart&action=viewCart">
            <button class="view-cart-button">View Cart</button>
        </a>
    </div>

</body>
</html>
