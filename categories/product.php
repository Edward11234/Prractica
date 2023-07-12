<?php
$pdo = require '../database/database.php';

// Verificați dacă a fost trimis un formular pentru lăsarea unei recenzii
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $review = $_POST["review"];
    $product_id = $_GET["id"]; // Obțineți ID-ul produsului din parametrul URL

    // Validați și procesați datele introduse de utilizator

    // Salvați recenzia în baza de date
    $stmt = $pdo->prepare("INSERT INTO reviews (product_id, review) VALUES (?, ?)");
    $stmt->execute([$product_id, $review]);
    // Puteți adăuga validări suplimentare, gestionarea erorilor etc.

    // Redirecționați utilizatorul înapoi pe pagina produsului după adăugarea recenziei
    header("Location: product.php?id=$product_id");
    exit;
}

// Obțineți ID-ul produsului din parametrul URL
$product_id = $_GET["id"];

// Interogați baza de date pentru a obține informațiile despre produs
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Interogați baza de date pentru a obține recenziile asociate produsului
$stmt = $pdo->prepare("SELECT * FROM reviews WHERE product_id = ?");
$stmt->execute([$product_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product</title>
</head>
<body>
<h1><?php echo $product["name"]; ?></h1>
<p><?php echo $product["description"]; ?></p>
<p>Price: <?php echo $product["price"]; ?></p>
<p>Stock: <?php echo $product["stock"]; ?></p>

<h2>Reviews</h2>
<?php foreach ($reviews as $review): ?>
    <p><?php echo $review["review"]; ?></p>
<?php endforeach; ?>

<h2>Add a Review</h2>
<form method="POST" action="product.php?id=<?php echo $product_id; ?>">
    <textarea name="review" rows="4" cols="50" placeholder="Enter your review"></textarea>
    <br>
    <button type="submit">Submit Review</button>
</form>
</body>
</html>
