<?php
session_start();


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'seller') {
    header('Location: index.php');
    exit();
}

$pdo = new PDO("mysql:host=hostname;dbname=nume_baza_date", "utilizator", "parola");

$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_product"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];


    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock]);

    header("Location: admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_product"])) {
    $product_id = $_POST["product_id"];

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$product_id]);

    header("Location: admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
<h1>Admin Panel</h1>

<h2>Add Product</h2>
<form method="POST" action="admin.php">
    <label for="name">Name:</label>
    <input type="text" name="name" required>
    <br>
    <label for="description">Description:</label>
    <textarea name="description" required></textarea>
    <br>
    <label for="price">Price:</label>
    <input type="number" name="price" required>
    <br>
    <label for="stock">Stock:</label>
    <input type="number" name="stock" required>
    <br>
    <button type="submit" name="add_product">Add Product</button>
</form>

<h2>Manage Products</h2>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product) { ?>
        <tr>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['description']; ?></td>
            <td><?php echo $product['price']; ?></td>
            <td><?php echo $product['stock']; ?></td>
            <td>
                <form method="POST" action="admin.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" name="delete_product">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
