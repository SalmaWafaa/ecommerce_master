<!DOCTYPE html>
<html>
<head>
    <title>Subcategories</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .category { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        .category h2 { margin: 0; }
        .category button { margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Subcategories</h1>

    <?php foreach ($categories as $category): ?>
        <div class="category">
            <h2><?= $category->getName() ?></h2>
            <button onclick="window.location.href='index.php?controller=Category&action=listProducts&id=<?= $category->getId() ?>'">
                View Products
            </button>
        </div>
    <?php endforeach; ?>
</body>
</html>