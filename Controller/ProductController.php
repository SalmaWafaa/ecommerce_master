<?php
include_once __DIR__ . '/../Model/Products/ProductModel.php';
include_once __DIR__ . '/../Model/Category/CategoryComposite.php';
class ProductController {

    // View Product Details
    public function viewProductDetails($productId) {
        $productModel = new ProductModel();
        $product = $productModel->getProductById($productId);

        if ($product) {
            $images = $productModel->getProductImages($productId);
            $sizes = $productModel->getProductSizes($productId);
            $colors = $productModel->getProductColors($productId);

            include __DIR__ . '/../View/products/product_details.php';
        } else {
            header('Location: /ecommerce_master/index.php?error=ProductNotFound');
            exit();
        }
    }

    // Add Product (Admin Only)
    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Safely handle form data and ensure required fields are set
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $images = isset($_POST['images']) ? explode(',', $_POST['images']) : [];
            $sizes = isset($_POST['sizes']) ? explode(',', $_POST['sizes']) : [];
            $colors = isset($_POST['colors']) ? explode(',', $_POST['colors']) : [];
            $product_type_id = $_POST['product_type_id'] ?? '';
            $on_sale = $_POST['on_sale'] ?? 0;  // Default to 0 if not set

            if (!$name || !$description || !$price || !$category_id) {
                echo "Please fill in all required fields.";
                return;
            }

            $productModel = new ProductModel();
            $productModel->addProduct($name, $description, $price, $category_id, $images, $sizes, $colors, $product_type_id, $on_sale);

            header("Location: index.php?controller=Product&action=listProducts&message=ProductAdded");
            exit();
        }

        include __DIR__ . '/../View/products/add_product_form.php';  // Correct path to the product edit form
    }

    // Edit Product (Admin Only)
    public function updateProduct($id) {
        // Get the product data from the database
        $productModel = new ProductModel();
        $categoryModel = new CategoryComposite();  // Assuming you have a CategoryModel to fetch categories
        $product = $productModel->getProductById($id);
        $categories = $categoryModel->getMainCategories();

        if (!$product) {
            // Handle error if product not found
            header("Location: index.php?controller=Product&action=listProducts&error=ProductNotFound");
            exit();
        }
    
        // Get associated product images, colors, and sizes
        $productImages = $productModel->getProductImages($id);
        $productColors = $productModel->getProductColors($id);
        $productSizes = $productModel->getProductSizes($id);
    
        // Pass the data to the view
        include __DIR__ . '/../View/products/edit_product_form.php';
    }

    // Delete Product (Admin Only)
    public function deleteProduct($id) {
        $productModel = new ProductModel();
        $productModel->deleteProduct($id);

        header("Location: index.php");
        exit();
    }
}
?>
