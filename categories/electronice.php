<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Home</title>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Edward</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../products.php">Produse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../categories.php">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log out</a>
            </li>
        </ul>
    </div>
</nav>
<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=login_db", "root", "");

$sql = "SELECT * FROM products WHERE category_id= '1' ";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afisarea produselor
foreach ($products as $product) {
    echo '<img src="../images/' . $product['image_url'] . '">';
    echo '<a href="product.php?id=' . $product['id'] . '">' . $product['name'] . '</a>';
    echo "Nume: " . $product['name'] . "<br>";
    echo "Descriere: " . $product['description'] . "<br>";
    echo "Pret: " . $product['price'] . "<br>";
    echo "Stoc: " . $product['stock'] . "<br>";

    echo "<br><br>";
}
