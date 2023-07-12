<?php
$pdo = require "../database/database.php";

$categoryStatement = $pdo->prepare("SELECT * FROM categories WHERE categories.id = :id");
$categoryStatement->bindValue(':id', $_GET['categoryId']);
$categoryStatement->execute();
$category = $categoryStatement->fetch(PDO::FETCH_ASSOC);

$productsStatement = $pdo->prepare("SELECT * FROM products WHERE category_id = :id");
$productsStatement->bindValue(':id', $category['id']);
$productsStatement->execute();
$products = $productsStatement->fetchAll();

if (!$category) {
    die('Categoria nu exsita.');
}
?>

<ul>
    <li>
        name: <?php echo $category['name']; ?>
    </li>
    <li>
        numar de produse: <?php echo count($products);?>
    </li>
</ul>

<ul>
    <?php foreach ($products as $product) { ?>
        <li>
            <?php echo $product['id'].'---'.$product['name']; ?>
        </li>
    <?php } ?>
</ul>