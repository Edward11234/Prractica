<?php
session_start();

$pdo = require __DIR__ . "/database/database.php";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$total = $_POST['total'] ?? 0;

if (isset($_POST['buy'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $card_number = $_POST['card_number'] ?? '';
    $expiration_date = $_POST['expiration_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (empty($card_number) || !preg_match('/^\d{16}$/', $card_number)) {
        $errors[] = "Invalid card number.";
    }
    if (empty($expiration_date) || !preg_match('/^\d{2}\/\d{2}$/', $expiration_date)) {
        $errors[] = "Invalid expiration date.";
    }
    if (empty($cvv) || !preg_match('/^\d{3}$/', $cvv)) {
        $errors[] = "Invalid CVV.";
    }

    if (empty($errors)) {
        try {
            $query = "INSERT INTO payments (name, email, card_number, expiration_date, cvv) VALUES (:name, :email, :card_number, :expiration_date, :cvv)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':card_number', $card_number);
            $stmt->bindParam(':expiration_date', $expiration_date);
            $stmt->bindParam(':cvv', $cvv);
            $stmt->execute();


            header("Location: payment_success.php");
            exit;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <title>Payment</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .payment-form {
            margin-top: 20px;
        }

        .payment-form label {
            display: block;
            margin-bottom: 5px;
        }

        .payment-form input[type="text"],
        .payment-form input[type="email"],
        .payment-form input[type="number"],
        .payment-form input[type="date"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        .payment-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php include 'html/navbar.php'; ?>
<div class="container">
    <h1>Payment</h1>

    <form method="POST" class="payment-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>

        <label for="expiration_date">Expiration Date:</label>
        <input type="text" id="expiration_date" name="expiration_date" placeholder="MM/YY" required>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <button type="submit" name="buy">Buy Now</button>
    </form>

    <p>Total de plata : $<?php echo $total; ?></p>
</div>

<script>
    setTimeout(function () {
        var errorMessages = document.getElementsByClassName('error-message');
        if (errorMessages) {
            Array.from(errorMessages).forEach(function (errorMessage) {
                errorMessage.style.display = 'none';
            });
        }
    }, 2000);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
