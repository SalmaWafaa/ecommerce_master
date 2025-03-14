<?php
require_once 'PaymentStrategy.php';
require_once "dbConnectionSingelton.php";


class Order  {
    private $paymentMethod;

    public function __construct(PaymentStrategy $paymentMethod) {
        $this->paymentMethod = $paymentMethod;
        //$this->db = Database::getInstance()->getConnection();
        

    }

    public static function getTotalAmount($orderId) {
        $db = DatabaseConnection::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT total FROM orders WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['total'] : 0;
    }
}
?>

