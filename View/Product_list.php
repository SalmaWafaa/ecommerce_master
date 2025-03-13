<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .product { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        .product h3 { margin: 0; }
    </style>
</head>
<body>
    <h1>Products</h1>

    <?php foreach ($products as $product): ?>
        <div class="product">
            <h3><?= $product->getName() ?></h3>
            <p>Price: $<?= $product->getPrice() ?></p>
            <p>Colors: <?= implode(", ", $product->getColors()) ?></p>
            <p>Sizes: <?= implode(", ", $product->getSizes()) ?></p>
            <p>Rating: <?= $product->getRate() ?> / 5</p>
        </div>
    <?php endforeach; ?>
</body>
</html>