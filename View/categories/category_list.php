<!-- C:\xampp\htdocs\ecommerce_master\View\categories\category_list.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <style>
        /* CSS for the box-based UI */
        .category-box, .subcategory-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            text-align: center;
            vertical-align: top; /* Ensure boxes align properly */
        }
        .actions {
            margin-top: 10px;
        }
        .actions button {
            margin: 5px;
        }
        h2, h3, h4 {
            margin: 0; /* Remove default margins for headings */
        }
    </style>
</head>
<body>
    <h1>Categories</h1>

    <!-- Add Category Button -->
    <a href="index.php?controller=Category&action=addCategoryForm">
        <button>Add Category</button>
    </a>

    <!-- Debugging: Print the $mainCategories array -->
    <?php 
    echo '<pre>';
    print_r($mainCategories);
    echo '</pre>';
    
    // Remove duplicate categories from the array
    $uniqueCategories = [];
    foreach ($mainCategories as $category) {
        if (!isset($uniqueCategories[$category['id']])) {
            $uniqueCategories[$category['id']] = $category;
        }
    }
    $mainCategories = array_values($uniqueCategories);
    ?>

    <!-- Main Categories and Subcategories -->
    <div>
        <?php if (!empty($mainCategories)): ?>
            <?php foreach ($mainCategories as $mainCategory): ?>
                <!-- Main Category Box -->
                <div class="category-box">
                    <h2><?php echo htmlspecialchars($mainCategory['name']); ?></h2>

                    <!-- Actions for Main Category -->
                    <div class="actions">
                        <a href="index.php?controller=Category&action=editCategoryForm&id=<?php echo $mainCategory['id']; ?>">
                            <button>Edit</button>
                        </a>
                        <a href="index.php?controller=Category&action=deleteCategoryForm&id=<?php echo $mainCategory['id']; ?>">
                            <button>Delete</button>
                        </a>
                    </div>

                    <!-- Subcategories Section -->
                    <h3>Subcategories</h3>
                    <?php if (!empty($mainCategory['subcategories'])): ?>
                        <?php foreach ($mainCategory['subcategories'] as $subcategory): ?>
                            <!-- Subcategory Box -->
                            <div class="subcategory-box">
                                <h4><?php echo htmlspecialchars($subcategory['name']); ?></h4>
                                <!-- Actions for Subcategory -->
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
                        <!-- No Subcategories Found -->
                        <p>No subcategories found.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- No Categories Found -->
            <p>No categories found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
