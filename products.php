<?php
session_start();

$pdo = require __DIR__ . "/database/database.php";

if (isset($_POST['add'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    try {
        $query = "SELECT `name`, `price` FROM `products` WHERE id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $product_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product_data && is_array($product_data)) {
            $price = (float)$product_data['price'];
            $product_total = $price * $quantity;
            $product = [
                'product_id' => $product_id,
                'name' => $product_data['name'],
                'price' => $price,
                'quantity' => $quantity,
                'total' => $product_total
            ];

            if (isset($_SESSION['cart'])) {
                $_SESSION['cart'][] = $product;
            } else {
                $_SESSION['cart'] = [$product];
            }

            $_SESSION['success_message'] = 'Produsul a fost adăugat în coș.';
            header("Location: products.php");
            exit;
        }
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    foreach ($_SESSION['cart'] as $key => $product) {
        if ($product['product_id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['success_message'] = 'Produsul a fost eliminat din coș.';
            header("Location: products.php");
            exit;
        }
    }
}

if (isset($_POST['remove_all'])) {
    unset($_SESSION['cart']);
    $_SESSION['success_message'] = 'Coșul de cumpărături a fost golit.';
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <title>Products</title>
    <style>

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-auto-rows: minmax(300px, auto);
            gap: 30px;
        }


        .product {
            display: flex;
            flex-direction: column;
            border: 5px solid blue;
            padding: 20px;
            box-sizing: border-box;

        }

        .product-image {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .product-description {
            flex: 1;
        }

        .product-description h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .product-description p {
            margin-bottom: 10px;
        }

        .product-description form {
            display: flex;
            align-items: center;
        }

        .product-description input[type="number"] {
            width: 50px;
            margin-right: 10px;
        }

        .product-description button {
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

        .product-description button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: green;
        }

        .cart-link {
            display: block;
            margin-top: 20px;
            text-align: left;
            margin-left: 20px;
        }

    </style>


</head>
<body>
<?php include 'html/navbar.php'; ?>
<div class="container-fluid">
    <h1 align="center">Products</h1>
    <p>Adauga un <a href="add_products.php">produs</a> nou</p>

    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="success-message"><?php echo $_SESSION['success_message']; ?></p>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <div class="products-grid">
        <?php
        $query = "SELECT * FROM products";
        $stmt = $pdo->query($query);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            ?>
            <div class="product">
                <img class="product-image" src="<?php echo $product['image_url']; ?>" alt="Imagine produs">

                <div class="product-description">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>Descriere: <?php echo $product['description']; ?></p>
                    <p>Preț: <?php echo $product['price']; ?></p>
                    <p>Stoc: <?php echo $product['stock']; ?></p>

                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <div class="form-group">
                            <label for="quantity">Cantitate:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1"
                                   max="<?php echo $product['stock']; ?>" class="form-control">
                        </div>
                        <br>
                        <button type="submit" name="add" class="btn btn-success">Adaugă în coș</button>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

        <div class="cart-link">
            <a href="cart.php">Vezi coșul de cumpărături</a>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>



