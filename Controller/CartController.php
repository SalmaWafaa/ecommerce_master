<?php

require_once './Model/CartModel.php';
require_once './Model/OrderModel.php';
require_once './Model/PaymentStrategy.php';

class CartController {
    private $cart;
    public function __construct() {
        $this->cart = Cart::getInstance();
        $customerId = $_SESSION['customer_id'] =1;
        
        if (!$customerId) {
            echo json_encode(['error' => 'User not logged in.']);
            exit;
        }
        
        $this->cart = Cart::getInstance();
        $this->cart->initializeCart($customerId);
    }

    public function initializeCart(int $userId): void {
        $this->cart->initializeCart($userId);
    }

    public function addItem(int $productId, int $quantity): void {
        $this->cart->addItem($productId, $quantity);
        echo "Item added to cart.";
    }

    public function removeItem(int $productId): void {
        $this->cart->removeItem($productId);
        echo "Item removed from cart.";
    }

    public function getItems(): array {
        return $this->cart->getItems();
    }

    public function getTotal(): float {
        return $this->cart->getTotal();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productId = intval($_POST['product_id']);

            if (isset($_POST['add'])) {
                $this->cart->addItem($productId, 1);
            } elseif (isset($_POST['remove'])) {
                $this->cart->removeItem($productId);
            }

            // Return updated cart details as JSON
            echo json_encode([
                'items' => $this->cart->getItems(),
                'total' => $this->cart->getTotal()
            ]);
            exit;
        }
    }
} $controller = new CartController();
$controller->handleRequest();



