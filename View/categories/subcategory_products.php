<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Products</title>
    <style>
        /* Product Grid Layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: auto;
            padding: 30px 0;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-box:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

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

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .add-to-cart-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        .add-to-cart-link:hover {
            background-color: #218838;
        }

        /* Admin Action Buttons */
        .admin-actions {
            margin-top: 20px;
            text-align: center;
        }

        .admin-actions button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        .admin-actions button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Products in <?php echo htmlspecialchars($subcategory->getName()); ?></h1>

        <!-- Product Grid -->
        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-box">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                        <a href="index.php?controller=Product&action=viewProductDetails&product_id=<?php echo $product['id']; ?>" class="add-to-cart-link">View Details</a>

                        <!-- Admin-only Action Buttons -->
                        <?php $userController = new UserController(); ?>
                        <?php if ($userController->isAdmin()): ?>
                            <div class="admin-actions">
                                <a href="index.php?controller=Product&action=editProduct&product_id=<?php echo $product['id']; ?>">
                                    <button>Edit</button>
                                </a>
                                <a href="index.php?controller=Product&action=deleteProduct&product_id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                                    <button>Delete</button>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found in this subcategory.</p>
            <?php endif; ?>
        </div>

        <!-- Add Product Button (only for admin) -->
        <?php if ($userController->isAdmin()): ?>
            <div class="admin-actions">
                <a href="index.php?controller=Product&action=addProduct">
                    <button>Add Product</button>
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
