<?php
class AdminDashboardModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllCustomers() {
        try {
            $query = "SELECT id, first_name, last_name, email 
                     FROM users 
                     WHERE user_type_id = 2 
                     ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllCustomers: " . $e->getMessage());
            return [];
        }
    }

    public function deleteCustomer($id) {
        try {
            $query = "DELETE FROM users WHERE id = :id AND user_type_id = 2";
            $stmt = $this->db->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error in deleteCustomer: " . $e->getMessage());
            return false;
        }
    }

    public function getAllProducts() {
        try {
            $query = "SELECT p.name, p.price, p.quantity, c.name as category_name 
                     FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     WHERE p.deleted = 0 
                     ORDER BY p.quantity ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllProducts: " . $e->getMessage());
            return [];
        }
    }

    public function getProductStatistics() {
        try {
            $stats = [];
            
            // Get total products and total stock
            $query = "SELECT COUNT(*) as total_products, 
                            SUM(quantity) as total_stock,
                            SUM(CASE WHEN quantity < 10 AND quantity > 0 THEN 1 ELSE 0 END) as low_stock,
                            SUM(CASE WHEN quantity = 0 THEN 1 ELSE 0 END) as out_of_stock
                     FROM products 
                     WHERE deleted = 0";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $stats['total_products'] = $result['total_products'];
            $stats['total_stock'] = $result['total_stock'] ?? 0;
            $stats['low_stock'] = $result['low_stock'];
            $stats['out_of_stock'] = $result['out_of_stock'];

            // Get low stock products details
            $query = "SELECT name, quantity, price 
                     FROM products 
                     WHERE quantity < 10 AND quantity > 0 AND deleted = 0";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $stats['low_stock_products'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $stats;
        } catch (PDOException $e) {
            error_log("Error in getProductStatistics: " . $e->getMessage());
            return [
                'total_products' => 0,
                'total_stock' => 0,
                'low_stock' => 0,
                'out_of_stock' => 0,
                'low_stock_products' => []
            ];
        }
    }
}
?> 