<?php
include_once __DIR__ . '/../../Model/Products/ProductModel.php';
include_once __DIR__ . '/../../config/dbConnectionSingelton.php'; // Include the database connection singleton

class ProductModel {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Get product by ID


    // Add a new product
    public function addProduct($name, $description, $price, $categoryId, $images, $sizes, $colors, $productTypeId, $onSale) {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("INSERT INTO products (name, description, price, category_id, product_type_id, on_sale) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $categoryId, $productTypeId, $onSale]);

            $productId = $this->db->lastInsertId();  // Get the inserted product ID

            // Insert images
            foreach ($images as $image) {
                $stmt = $this->db->prepare("INSERT INTO productimages (product_id, image_url) VALUES (?, ?)");
                $stmt->execute([$productId, $image]);
            }

            // Insert sizes
            foreach ($sizes as $size) {
                $stmt = $this->db->prepare("INSERT INTO productsizes (product_id, size) VALUES (?, ?)");
                $stmt->execute([$productId, $size]);
            }

            // Insert colors
            foreach ($colors as $color) {
                $stmt = $this->db->prepare("INSERT INTO productcolors (product_id, color) VALUES (?, ?)");
                $stmt->execute([$productId, $color]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Update product details
    public function deleteProduct($id) {
        try {
            $this->db->beginTransaction();
    
            // Delete related cart items first to avoid foreign key constraint error
            $this->db->prepare("DELETE FROM cartitem WHERE product_id = ?")->execute([$id]);
    
            // Delete related product images
            $this->db->prepare("DELETE FROM productimages WHERE product_id = ?")->execute([$id]);
    
            // Delete related product colors
            $this->db->prepare("DELETE FROM productcolors WHERE product_id = ?")->execute([$id]);
    
            // Delete related product sizes
            $this->db->prepare("DELETE FROM productsizes WHERE product_id = ?")->execute([$id]);
    
            // Now delete the product itself
            $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
    
            // Check if the product was deleted (no rows affected means failure)
            if ($stmt->rowCount() === 0) {
                throw new Exception('Product deletion failed. No rows affected.');
            }
    
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function updateProduct($id, $name, $description, $price, $categoryId, $images, $sizes, $colors, $productTypeId, $onSale) {
        try {
            // Start transaction
            $this->db->beginTransaction();
    
            // Prepare the SQL statement for updating the product
            $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, product_type_id = ?, on_sale = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $categoryId, $productTypeId, $onSale, $id]);
    
            // Check if product was updated (if no rows were affected, the update failed)
            if ($stmt->rowCount() === 0) {
                throw new Exception('Product update failed. No rows affected.');
            }
    
            // Delete existing related data in productimages, productcolors, and productsizes
            $this->db->prepare("DELETE FROM productimages WHERE product_id = ?")->execute([$id]);
            $this->db->prepare("DELETE FROM productcolors WHERE product_id = ?")->execute([$id]);
            $this->db->prepare("DELETE FROM productsizes WHERE product_id = ?")->execute([$id]);
    
            // Insert new data for images, sizes, and colors
            foreach ($images as $image) {
                $stmt = $this->db->prepare("INSERT INTO productimages (product_id, image_url) VALUES (?, ?)");
                $stmt->execute([$id, $image]);
            }
    
            foreach ($sizes as $size) {
                $stmt = $this->db->prepare("INSERT INTO productsizes (product_id, size) VALUES (?, ?)");
                $stmt->execute([$id, $size]);
            }
    
            foreach ($colors as $color) {
                $stmt = $this->db->prepare("INSERT INTO productcolors (product_id, color) VALUES (?, ?)");
                $stmt->execute([$id, $color]);
            }
    
            // Commit the transaction
            $this->db->commit();
        } catch (Exception $e) {
            // Rollback transaction if an error occurs
            $this->db->rollBack();
            throw $e;
        }
    }
        
    public function getProductById($productId) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$productId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductsBySubcategory($subcategoryId) {
        $query = "SELECT * FROM products WHERE subcategory_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$subcategoryId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get the images for a specific product by product ID
public function getProductImages($productId) {
    $query = "SELECT * FROM productimages WHERE product_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all images related to the product
}
// Get the sizes for a specific product by product ID
public function getProductSizes($productId) {
    $query = "SELECT * FROM productsizes WHERE product_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all sizes related to the product
}
// Get the colors for a specific product by product ID
public function getProductColors($productId) {
    $query = "SELECT * FROM productcolors WHERE product_id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all colors related to the product
}
}
?>
