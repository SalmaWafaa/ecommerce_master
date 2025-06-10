<?php
class OrderView {
    public static function displayOrder(Order $order) {
        echo "Order ID: " . $order->getOrderId() . "\n";
        echo "Order Status: " . $order->getOrderStatus() . "\n";
        echo "Order Total: $" . $order->getOrderTotal() . "\n";
    }
}
?>
