<?php
require_once 'IObserver.php';

class Shipping implements IObserver {
    public function update(int $orderId) {
        echo "Prepare Shipment for Order ID: {$orderId}\n";
    }
}
?>
