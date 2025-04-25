<!DOCTYPE html>
<html>
<head>
    <title>Payment Form</title>
</head>
<body>
    <h2>Select Payment Method</h2>
    <form action="index.php?controller=Payment&action=handlePayment" method="post">
        <input type="hidden" name="amount" value="<?= htmlspecialchars($_GET['amount'] ?? 0) ?>">

        <label><input type="radio" name="method" value="credit" required> Credit Card</label><br>
        <label><input type="radio" name="method" value="paypal"> PayPal</label><br>
        <label><input type="radio" name="method" value="cash"> Cash on Delivery</label><br><br>

        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
