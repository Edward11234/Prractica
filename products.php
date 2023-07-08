<?php

$mysqli = require __DIR__ . "/database/database.php";


$stmt = $mysqli->query("SELECT * FROM products");
$products = $stmt->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produse</title>
    <style>
        .product {
            display: inline-block;
            margin: 20px;
            text-align: center;
        }

        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .product-description {
            margin-top: 10px;
        }
    </style>
</head>
<body>
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
        </div>
    </div>
<?php } ?>

</body>
</html>
