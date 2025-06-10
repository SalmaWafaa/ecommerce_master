<?php
require_once 'IObserver.php';

class InventoryCheck implements IObserver {
    public function update(int $orderId) {
        echo "Inventory Check for Order ID: {$orderId}\n";
    }
}
?>
