<?php
require_once __DIR__ . '/../../Model/Orders/Order.php';

// OrderController.php
session_start(); // Start session before using $_SESSION

class OrderController {
    public function createOrder() {
        // Retrieve customer ID and cart data from the session
        $customerId = $_SESSION['customer_id'] ?? 1;
        $cartItems = $_SESSION['cart_id'] ?? [];

        // Debugging: Check cart contents
        var_dump($cartItems);

        // Proceed with the order creation logic if cart is not empty
        if (empty($cartItems)) {
            echo "🛒 Cart is empty. Cannot place order.";
            return;
        }

        // Payment method logic
        $paymentType = $_GET['payment_type'] ?? 'CreditCard';

        // Reformat the cart items
        $items = array_map(function ($item) {
            return [
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price']
            ];
        }, $cartItems);

        try {
            // Create the order
            $order = new Order();
            $order->createOrder($customerId, $items, $paymentType);

            // Clear the cart after order is placed
            unset($_SESSION['cart']);

            // Display confirmation
            echo "<h2>✅ Order placed successfully!</h2>";
            echo "<p>Order ID: " . $order->getOrderId() . "</p>";
            echo "<p>Total: $" . number_format($order->getOrderTotal(), 2) . "</p>";
            echo "<a href='index.php'>Go back to Home</a>";
        } catch (Exception $e) {
            // Handle errors
            echo "❌ Failed to place order: " . $e->getMessage();
        }
    }
}
