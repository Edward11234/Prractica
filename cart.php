<?php
session_start();

$pdo = require __DIR__ . "/database/database.php";

$cart = $_SESSION['cart'] ?? [];
$total = 0;

if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    foreach ($cart as $key => $product) {
        if ($product['product_id'] == $product_id) {
            unset($cart[$key]);
            $_SESSION['cart'] = $cart;
            break;
        }
    }
}

if (isset($_POST['remove_all'])) {
    unset($_SESSION['cart']);
    $_SESSION['success_message'] = 'Coșul de cumpărături a fost golit.';
    header("Location: cart.php");
    exit;
}

foreach ($cart as $product) {
    $total += $product['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <title>Shopping Cart</title>
    <style>
    .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    }

    .cart-table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    }

    .cart-table th,
    .cart-table td {
    padding: 8px;
    border: 1px solid #ccc;
    text-align: center;
    }

    .cart-table th {
    background-color: #f2f2f2;
    font-weight: bold;
    }

    .cart-table .product-name {
    text-align: left;
    }

    .cart-table .cart-remove {
    width: 100px;
    }

    .cart-table .cart-remove form {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    margin: 0;
    }

    .cart-table .cart-remove button {
    background-color: transparent;
    color: red;
    border: none;
    padding: 0;
    cursor: pointer;
    }

    .cart-total {
    margin-top: 20px;
    text-align: right;
    }

    .cart-link {
    display: block;
    margin-top: 20px;
    text-align: right;
    }
  </style>

</head>
<body>

<?php include 'html/navbar.php'; ?>
<div class="container">
    <h1 align="center">Shopping Cart</h1><br>

    <table class="cart-table">
        <thead>
        <tr>
            <th class="product-name">Product Name</th>
            <th class="product-price">Price</th>
            <th class="product-quantity">Quantity</th>
            <th class="product-total">Total</th>
            <th class="cart-remove">Remove</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cart as $product): ?>
            <tr>
                <td class="product-name"><?php echo $product['name']; ?></td>
                <td class="product-price"><?php echo $product['price']; ?></td>
                <td class="product-quantity"><?php echo $product['quantity']; ?></td>
                <td class="product-total"><?php echo $product['total']; ?></td>
                <td class="cart-remove">
                    <form method="POST" class="remove-form">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <button type="submit" name="remove">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($cart)): ?>
        <p>Your shopping cart is empty.</p>
    <?php else: ?>
        <div class="cart-total">
            <strong>Total: <?php echo $total; ?></strong>
        </div>

        <form method="POST">
            <button type="submit" name="remove_all">Empty Cart</button>
        </form>
    <br>
        <form method="POST" action="payment.php">
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <button type="submit" name="buy">Buy Now</button>
        </form>



    <?php endif; ?>

    <div class="cart-link">
        <a href="products.php">Back to Products</a>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
