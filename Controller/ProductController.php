
<?php

require_once 'C:\xampp\htdocs\ecommerce_master\Model\Products\ProductFactory.php';

class ProductController {
    public function addProductForm() {
        include 'C:\xampp\htdocs\ecommerce_master\View\products\add_product_form.php';
    }

    public function createProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'category_id' => $_POST['category_id'],
                'product_type_id' => $_POST['product_type_id'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'on_sale' => $_POST['on_sale'],
                'rate' => $_POST['rate'],
                'quantity' => $_POST['quantity']
            ];

            try {
                $product = ProductFactory::createProduct($data);
                if ($product->create()) {
                    header("Location: index.php?controller=Category&action=viewSubcategoryProducts&category_id={$product->category_id}");
                    exit();
                } else {
                    echo "Failed to create product.";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
    public function deleteProductForm($id) {
        $product = new Product();
        $productData = $product->readOne($id);
        
        if (!$productData) {
            echo "Product not found.";
            return;
        }
    
        include 'C:\xampp\htdocs\ecommerce_master\View\products\delete_product_form.php';
    }

    public function editProductForm($id) {
        $product = $this->getProductById($id);
    
        if (!$product) {
            die("Error: Product not found.");
        }
    
        // Pass the product to the view
        include 'C:/xampp/htdocs/ecommerce_master/View/products/edit_product_form.php';
    }
    public function getProductById($id) {
        $product = new Product();
        return $product->readOne($id);
    }
    public function updateProduct($id, $data = null) {
        $product = new Product();
        $product->id = $id;
    
        // If $data is not provided, fetch it from $_POST
        if ($data === null) {
            $data = $_POST;
        }
    
        // Assign values from $data to the product object
        $product->name = $data['name'] ?? '';
        $product->category_id = $data['category_id'] ?? '';
        $product->product_type_id = $data['product_type_id'] ?? '';
        $product->description = $data['description'] ?? '';
        $product->price = $data['price'] ?? 0;
        $product->on_sale = $data['on_sale'] ?? 0;
        $product->rate = $data['rate'] ?? 0;
        $product->quantity = $data['quantity'] ?? 0;
    
        // Update the product
        if ($product->update()) {
            header("Location: index.php?controller=Product&action=editProductForm&id=$id&status=success");
            exit();
        } else {
            die("Error: Failed to update product.");
        }
    }
    // Delete a product
    public function deleteProduct($id) {
        $product = new Product();
        $product->id = $id;
    
        if ($product->delete()) {
            // Redirect to the list of products or categories after successful deletion
            header("Location: index.php?controller=Category&action=listCategories&status=deleted");
            exit();
        } else {
            die("Error: Failed to delete product.");
        }
    }
    // Other methods (deleteProductForm, editProductForm, getAllProducts, getProductById, updateProduct, deleteProduct) remain unchanged
}