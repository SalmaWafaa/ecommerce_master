<!-- C:\xampp\htdocs\ecommerce_master\View\categories\category_details.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details</title>
    <style>
        .subcategory-box {
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
    <h1>Subcategories</h1>
    <a href="index.php?controller=Category&action=listCategories">Back to Main Categories</a>
    <div>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $subcategory): ?>
                <div class="subcategory-box">
                    <h3><?php echo htmlspecialchars($subcategory['name']); ?></h3>
                    <div class="actions">
                        <a href="index.php?controller=Category&action=editCategoryForm&id=<?php echo $subcategory['id']; ?>">
                            <button>Edit</button>
                        </a>
                        <a href="index.php?controller=Category&action=deleteCategoryForm&id=<?php echo $subcategory['id']; ?>">
                            <button>Delete</button>
                        </a>
                        <a href="index.php?controller=Category&action=viewSubcategoryProducts&subcategory_id=<?php echo $subcategory['id']; ?>">
                            <button>View Products</button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No subcategories found.</p>
        <?php endif; ?>
    </div>
</body>
</html>