<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .stats-card {
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .table-responsive {
            margin-top: 20px;
        }
        .low-stock {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin Dashboard</h1>
            <a href="index.php" class="btn btn-primary">← Back to Home</a>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stats-card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <h2 class="card-text"><?php echo isset($data['statistics']['total_products']) ? $data['statistics']['total_products'] : 0; ?></h2>
                        <p>Total Stock: <?php echo isset($data['statistics']['total_stock']) ? number_format($data['statistics']['total_stock']) : 0; ?> items</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Low Stock Products</h5>
                        <h2 class="card-text"><?php echo isset($data['statistics']['low_stock']) ? $data['statistics']['low_stock'] : 0; ?></h2>
                        <p>Products with stock < 10</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stats-card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Out of Stock</h5>
                        <h2 class="card-text"><?php echo isset($data['statistics']['out_of_stock']) ? $data['statistics']['out_of_stock'] : 0; ?></h2>
                        <p>Products need restock</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert Section -->
        <?php if (!empty($data['statistics']['low_stock_products'])): ?>
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h3><i class="fas fa-exclamation-triangle"></i> Low Stock Alert</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Current Stock</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['statistics']['low_stock_products'] as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td class="low-stock"><?php echo $product['quantity']; ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php 
        // Pass data to partial views
        $products = $data['products'] ?? [];
        $customers = $data['customers'] ?? [];
        
        // Include partial views
        require_once 'View/partials/products_table.php';
        require_once 'View/partials/customers_table.php';
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteCustomer(customerId) {
            if (confirm('Are you sure you want to delete this customer?')) {
                window.location.href = `index.php?controller=AdminDashboard&action=deleteCustomer&id=${customerId}`;
            }
        }
    </script>
</body>
</html> 