<!-- Products Section -->
<div class="card mb-4">
    <div class="card-header">
        <h3>Products Inventory</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($products) && is_array($products)): ?>
                    <?php foreach ($products as $product): ?>
                    <tr <?php echo $product['quantity'] < 10 ? 'class="table-warning"' : ''; ?>>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td <?php echo $product['quantity'] < 10 ? 'class="low-stock"' : ''; ?>>
                            <?php echo $product['quantity']; ?>
                        </td>
                        <td>
                            <?php if ($product['quantity'] == 0): ?>
                                <span class="badge bg-danger">Out of Stock</span>
                            <?php elseif ($product['quantity'] < 10): ?>
                                <span class="badge bg-warning text-dark">Low Stock</span>
                            <?php else: ?>
                                <span class="badge bg-success">In Stock</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 