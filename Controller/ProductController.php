<?php

require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\Product.php';

class ProductController {
    public function addProductForm() {
        include 'C:\xampp\htdocs\ecommerce_master\View\products\add_product_form.php';
    }
    // Create a product
    public function createProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = new Product();
            $product->name = $_POST['name'];
            $product->category_id = $_POST['category_id'];
            $product->product_type_id = $_POST['product_type_id'];
            $product->description = $_POST['description'];
            $product->price = $_POST['price'];
            $product->on_sale = $_POST['on_sale'];
            $product->rate = $_POST['rate'];
            $product->quantity = $_POST['quantity'];

            if ($product->create()) {
                header("Location: index.php?controller=Category&action=viewSubcategoryProducts&category_id={$product->category_id}");
                exit();
            } else {
                echo "Failed to create product.";
            }
        }
    }

    // Get all products
    public function getAllProducts() {
        $product = new Product();
        return $product->read();
    }

    // Get a single product by ID
    public function getProductById($id) {
        $product = new Product();
        return $product->readOne($id);
    }

    // Update a product
    public function updateProduct($id, $data) {
        $product = new Product();
        $product->id = $id;
        $product->name = $data['name'];
        $product->category_id = $data['category_id'];
        $product->product_type_id = $data['product_type_id'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->on_sale = $data['on_sale'];
        $product->rate = $data['rate'];
        $product->quantity = $data['quantity'];

        if ($product->update()) {
            return "Product updated successfully.";
        } else {
            return "Failed to update product.";
        }
    }

    // Delete a product
    public function deleteProduct($id) {
        $product = new Product();
        $product->id = $id;

        if ($product->delete()) {
            return "Product deleted successfully.";
        } else {
            return "Failed to delete product.";
        }
    }
}