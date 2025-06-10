<?php
require_once 'ISubject.php';
require_once __DIR__ . '/../../config/dbConnectionSingelton.php';

class Order implements ISubject {
    private $orderId;
    private $orderStatus;
    private $orderTotal;
    private $observers = [];

    public function attach(IObserver $observer) {
        $this->observers[] = $observer;
    }

    public function detach(IObserver $observer) {
        foreach ($this->observers as $key => $obs) {
            if ($obs === $observer) {
                unset($this->observers[$key]);
            }
        }
    }

    public function notifyObservers() {
        foreach ($this->observers as $observer) {
            $observer->update($this->orderId);
        }
    }

    public function createOrder($customerId, $items, $paymentType) {
        $db = Database::getInstance()->getConnection();

        // Calculate the order total
        $this->orderTotal = $this->calculateTotal($items);
        $this->orderStatus = "Pending";  // Set the default status for the order

        // Insert the order into the orders table
        $stmt = $db->prepare("INSERT INTO orders (customer_id, date_created,  total, status, payment_type) 
                              VALUES (:customer_id, NOW(), :total,:status,  :payment_type)");
        $stmt->execute([
            'customer_id' => $customerId,
            'status' => $this->orderStatus,
            'total' => $this->orderTotal,
            'payment_type' => $paymentType
        ]);

        // Get the last inserted order ID
        $this->orderId = $db->lastInsertId();

        // Insert each item from the cart into the orderitems table
        foreach ($items as $item) {
            $stmt = $db->prepare("INSERT INTO orderitems (order_id, product_id, quantity, price, total, created_at)
                                  VALUES (:order_id, :product_id, :quantity, :price, :total, NOW())");
            $stmt->execute([
                'order_id' => $this->orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price']
            ]);
        }
    }

    // Calculate the total price of the order based on cart items
    private function calculateTotal($items) {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    // Getter methods for order information
    public function getOrderId() { return $this->orderId; }
    public function getOrderStatus() { return $this->orderStatus; }
    public function getOrderTotal() { return $this->orderTotal; }



    public function updateOrderStatus($status) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        $stmt->execute([
            'status' => $status,
            'order_id' => $this->orderId
        ]);
        $this->orderStatus = $status;

        $this->notifyObservers();
    }




}