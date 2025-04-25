<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add New Product</h2>
    <form action="../controllers/ProductController.php" method="POST">
        <input type="hidden" name="action" value="add">

        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" placeholder="Price" step="0.01" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="number" name="discount" placeholder="Discount" required>

        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <h3>Product Images (URLs)</h3>
        <div id="image-fields">
            <input type="text" name="images[]" placeholder="Image URL">
        </div>
        <button type="button" onclick="addImageField()">+ Add Image</button>

        <h3>Product Colors</h3>
        <div id="color-fields">
            <input type="text" name="colors[]" placeholder="Color Name">
        </div>
        <button type="button" onclick="addColorField()">+ Add Color</button>

        <h3>Product Sizes</h3>
        <div id="size-fields">
            <input type="text" name="sizes[]" placeholder="Size Name">
        </div>
        <button type="button" onclick="addSizeField()">+ Add Size</button>

        <br><br>
        <button type="submit">Add Product</button>
    </form>
</div>

<script>
    function addImageField() {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'images[]';
        input.placeholder = 'Image URL';
        document.getElementById('image-fields').appendChild(input);
    }

    function addColorField() {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'colors[]';
        input.placeholder = 'Color Name';
        document.getElementById('color-fields').appendChild(input);
    }

    function addSizeField() {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'sizes[]';
        input.placeholder = 'Size Name';
        document.getElementById('size-fields').appendChild(input);
    }
</script>
</body>
</html>
