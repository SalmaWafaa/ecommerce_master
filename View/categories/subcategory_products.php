<!-- C:\xampp\htdocs\ecommerce_master\View\categories\subcategory_products.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategory Products</title>
    <style>
        .product-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            text-align: center;
        }
        .actions {
            margin-top: 10px;
        }
        .actions button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <h1>Products</h1>
    <a href="index.php?controller=Category&action=listCategories">Back to Categories</a>
    <div class="actions">
        <a href="index.php?controller=Product&action=addProductForm&category_id=<?php echo $_GET['subcategory_id']; ?>">
            <button>Add Product</button>
        </a>
    </div>
    <div>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-box">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p>Price: $<?php echo number_format($product['price'], 2); ?></p>
                    <p>Quantity: <?php echo $product['quantity']; ?></p>
                    <div class="actions">
                        <a href="index.php?controller=Product&action=editProductForm&id=<?php echo $product['id']; ?>">
                            <button>Edit</button>
                        </a>
                        <a href="index.php?controller=Product&action=deleteProductForm&id=<?php echo $product['id']; ?>">
                            <button>Delete</button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found in this subcategory.</p>
        <?php endif; ?>
    </div>
</body>
</html>