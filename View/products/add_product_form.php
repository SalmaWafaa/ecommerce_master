<?php
// add_product_form.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Add New Product</h1>
    <form action="index.php?controller=Product&action=createProduct" method="POST">
        <!-- Product Name -->
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>

        <!-- Category ID -->
        <label for="category_id">Category ID:</label>
        <input type="number" id="category_id" name="category_id" required>

        <!-- Product Type ID -->
        <label for="product_type_id">Product Type:</label>
        <select id="product_type_id" name="product_type_id" required>
            <option value="1">Basic Shirt</option>
            <option value="2">Basic Pants</option>
            <!-- Add more options as needed -->
        </select>

        <!-- Description -->
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <!-- Price -->
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <!-- On Sale Percentage -->
        <label for="on_sale">On Sale Percentage:</label>
        <input type="number" id="on_sale" name="on_sale" step="0.01" min="0" max="100" required>

        <!-- Rate -->
        <label for="rate">Rate:</label>
        <input type="number" id="rate" name="rate" step="0.1" required>

        <!-- Quantity -->
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <!-- Submit Button -->
        <input type="submit" value="Add Product">
    </form>
</body>
</html>