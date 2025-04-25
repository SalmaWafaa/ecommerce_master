<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
</head>
<body>
    <h1>Your Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price (Each)</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><img src="/ecommerce_master/uploads/<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="80"></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($item['price'], 2)) ?></td>
                        <td>$<?= htmlspecialchars(number_format($item['total_price'], 2)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Proceed to Payment Button -->
        <div style="margin-top: 20px;">
            <form action="/Controller/PaymentController.php?controller=Payment&action=showPaymentForm" method="GET">
                <input type="hidden" name="controller" value="Payment">
                <input type="hidden" name="action" value="showPaymentForm">
                <button type="submit" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Proceed to Payment</button>
            </form>
        </div>
        <?php if (!empty($cartItems)): ?>
    <!-- Existing cart table code... -->

    <form action="index.php" method="get">
        <input type="hidden" name="controller" value="Payment">
        <input type="hidden" name="action" value="showPaymentForm">
        <input type="hidden" name="amount" value="<?= array_sum(array_column($cartItems, 'total_price')) ?>">
        <button type="submit">Proceed to Payment</button>
    </form>
<?php endif; ?>


    <?php endif; ?>
</body>
</html>
