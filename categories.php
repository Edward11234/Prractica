<?php include 'html/navbar.php'; ?>
<?php
    $pdo = require './database/database.php';
    $categories = $pdo->query("SELECT * FROM categories WHERE 1")->fetchAll();
?>
<h1>Categories</h1>
<ul>
<!--    <li><a href="categories/masini.php">Masini</a></li>-->
<!--    <li><a href="categories/electronice.php">Electronice</a></li>-->
<!--    <li><a href="categories/articole_sportive.php">Articole sportive</a></li>-->
<!--    <li><a href="categories/nutritie.php">Nutritie</a></li>-->
    <?php foreach ($categories as $category) {?>
        <li>
            <a href="categories/show.php?categoryId=<?php echo $category['id'] ?>">
                <?php echo $category['name']; ?>
            </a>
        </li>
    <?php }?>
</ul>
</body>
</html>