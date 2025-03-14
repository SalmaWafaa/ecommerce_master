<!-- C:\xampp\htdocs\ecommerce_master\View\products\edit_product_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="index.php?controller=Product&action=updateProduct&id=<?php echo $product['id']; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $product['description']; ?></textarea><br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required><br>
        <button type="submit">Update Product</button>
    </form>
</body>
</html>