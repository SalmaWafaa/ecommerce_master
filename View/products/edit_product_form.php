<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="path_to_your_css_file.css">
    <style>
        /* Basic CSS to style the form */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .product-images, .product-colors, .product-sizes {
            display: flex;
            flex-direction: column;
        }

        .product-images img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .product-images, .product-sizes, .product-colors {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit Product</h1>

    <!-- Display error message if any -->
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?controller=Product&action=updateProduct&id=<?php echo $product['id']; ?>" method="POST">
        <label for="name">Product Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label for="description">Product Description</label>
        <input type="text" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" required>

        <label for="price">Price</label>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

        <!-- Select Category -->
    <label for="category_id">Select Category</label>
    <select name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category->getId(); ?>"
                <?php echo $category->getId() == $product['category_id'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($category->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>

        <div class="product-images">
            <label>Product Images</label>
            <!-- Display images -->
            <?php if (!empty($productImages)): ?>
                <?php foreach ($productImages as $image): ?>
                    <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Product Image">
                <?php endforeach; ?>
            <?php endif; ?>
            <input type="text" name="images" placeholder="Enter image URLs, separated by commas">
        </div>

        <div class="product-colors">
            <label>Product Colors</label>
            <!-- Display colors -->
            <?php if (!empty($productColors)): ?>
                <?php foreach ($productColors as $color): ?>
                    <div><?php echo htmlspecialchars($color['color']); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <input type="text" name="colors" placeholder="Enter colors, separated by commas">
        </div>

        <div class="product-sizes">
            <label>Product Sizes</label>
            <!-- Display sizes -->
            <?php if (!empty($productSizes)): ?>
                <?php foreach ($productSizes as $size): ?>
                    <div><?php echo htmlspecialchars($size['size']); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <input type="text" name="sizes" placeholder="Enter sizes, separated by commas">
        </div>

        <label for="on_sale">On Sale</label>
        <select name="on_sale">
            <option value="1" <?php echo $product['on_sale'] ? 'selected' : ''; ?>>Yes</option>
            <option value="0" <?php echo !$product['on_sale'] ? 'selected' : ''; ?>>No</option>
        </select>

        <button type="submit">Update Product</button>
    </form>
</div>

</body>
</html>

