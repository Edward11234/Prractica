<?php

$pdo = require __DIR__ . "/database/database.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['success_message'])) {
    echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
    unset($_SESSION['success_message']);
}

// Afișați produsele din coș
if (!empty($_SESSION['cart'])) {
    echo '<h2>Produse în coș:</h2>';
    echo '<ul>';
    foreach ($_SESSION['cart'] as $product) {
        echo '<li>' . $product . '</li>';
    }
    echo '</ul>';
}
?>

<?php include 'html/navbar.php' ; ?>

<h1>Produse</h1>
<p>Adauga un <a href="add_products.php">produs</a> nou </p>

<?php foreach ($products as $product) { ?>
    <div class="product">
        <img class="product-image" src="<?php echo $product['image_url']; ?>" alt="Imagine produs">

        <div class="product-description">
            <h3><?php echo $product['name']; ?></h3>
            <p>Descriere: <?php echo $product['description']; ?></p>
            <p>Preț: <?php echo $product['price']; ?></p>
            <p>Stoc: <?php echo $product['stock']; ?></p>

            <form method="POST" action="cart/add_to_cart.php">
                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                <button type="submit">Adaugă în coș</button>
            </form>
        </div>
    </div>
<?php } ?>

</body>
</html>
