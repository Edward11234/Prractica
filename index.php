<?php

session_start();
$pdo = require __DIR__ . "/database/database.php";


$categoriesQuery = "SELECT * FROM categories";
$categoriesStmt = $pdo->query($categoriesQuery);
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">

    <title>Home</title>

    <style>
        .carousel-image {
            height: 600px;
            object-fit: cover;
        }
        .content-container {
            margin-left: 600px;
        }
        .product-image {
            height: 200px;
            object-fit: contain;
        }
        .product-container {
            border-width: 20px;
            border-color: blue;
            padding: 20px;
            box-sizing: border-box;
        }


    </style>


</head>
<body>
<?php include 'html/navbar.php'; ?>

<div class="container-fluid ml-auto content-container">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner";">
            <div class="carousel-item active">
                <img class="d-block w-100 carousel-image" src="images/concurs.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 carousel-image" src="images/poza.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 carousel-image" src="images/marketing.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

<br>
<?php if (!empty($categories)): ?>
    <?php foreach ($categories as $category): ?> <br>
        <h2><?= htmlspecialchars($category['name']) ?></h2>

        <div class="product-container row">
            <?php
            $categoryId = $category['id'];
            $productsQuery = "SELECT * FROM products WHERE category_id = :category_id";
            $productsStmt = $pdo->prepare($productsQuery);
            $productsStmt->bindValue(':category_id', $categoryId);
            $productsStmt->execute();
            $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($products as $product): ?>
                <div class="col-md-4">
                    <br>
                    <div class="card product-card" style="border: 2px solid blue;">
                        <img class="card-img-top product-image" src="<?= htmlspecialchars($product['image_url']) ?>" alt="Product Image">
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text">Price: <?= htmlspecialchars($product['price']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No categories found.</p>
<?php endif; ?>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
