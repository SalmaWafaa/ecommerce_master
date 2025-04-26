<?php
require_once 'Model/AdminDashboardModel.php';
require_once 'Model/Admin.php';

class AdminDashboardController {
    private $model;
    private $admin;
    private $view = 'admin_dashboard.php';

    public function __construct() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->model = new AdminDashboardModel();
        
        // Create admin instance if user is logged in
        if (isset($_SESSION['user_id'])) {
            $this->admin = new Admin(
                $_SESSION['user_id'],
                $_SESSION['first_name'] ?? null,
                $_SESSION['last_name'] ?? null,
                $_SESSION['email'] ?? null
            );
        }
    }

    public function index() {
        // Get all required data for the dashboard
        $data = [
            'statistics' => $this->model->getProductStatistics(),
            'products' => $this->model->getAllProducts(),
            'customers' => $this->model->getAllCustomers()
        ];

        // Extract data to make it available in view scope
        extract($data);
        
        // Load the view
        require_once "View/{$this->view}";
    }

    public function deleteCustomer() {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "Customer ID not provided";
            header('Location: index.php?controller=AdminDashboard');
            exit;
        }

        $customerId = (int)$_GET['id'];
        
        if ($this->model->deleteCustomer($customerId)) {
            $_SESSION['message'] = "Customer deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete customer";
        }

        header('Location: index.php?controller=AdminDashboard');
        exit;
    }
}
?> 