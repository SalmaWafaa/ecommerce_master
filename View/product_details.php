<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
</head>
<body>
    <h1>Product Details</h1>
    <?php if ($product): ?>
        <h2><?= $product->getName() ?></h2>
        <p>Description: <?= $product->getDescription() ?></p>
        <p>Price: $<?= $product->getPrice() ?></p>
        <p>Colors: <?= implode(", ", $product->getColors()) ?></p>
        <p>Sizes: <?= implode(", ", $product->getSizes()) ?></p>
        <p>Rating: <?= $product->getRate() ?> / 5</p>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
</body>
</html>