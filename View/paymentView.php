<!DOCTYPE html>
<html>
<head>
    <title>Order Checkout</title>
</head>
<body>
    <h2>Checkout</h2>
    <form action="../Controller/OrderController.php" method="POST">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" required>
        <br><br>

        <label>Choose Payment Method:</label>
        <select name="payment_method">
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
        </select>
        <br><br>

        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
