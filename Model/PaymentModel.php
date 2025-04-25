<?php
require_once __DIR__ . '/../config/dbConnectionSingelton.php';

class PaymentModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function savePayment($orderId, $billingAddressId, $paymentMethod, $paymentStatus, $paymentCode, $paidAmount) {
        $query = "INSERT INTO payment (order_id, billing_address_id, payment_method, payment_status, payment_code, paid_amount, paid_at, created_at)
                  VALUES (:order_id, :billing_address_id, :payment_method, :payment_status, :payment_code, :paid_amount, NOW(), NOW())";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':billing_address_id', $billingAddressId);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':payment_status', $paymentStatus);
        $stmt->bindParam(':payment_code', $paymentCode);
        $stmt->bindParam(':paid_amount', $paidAmount);

        return $stmt->execute();
    }
}
