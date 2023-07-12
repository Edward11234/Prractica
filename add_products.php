<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$pdo = require __DIR__ . "/database/database.php";

function showSuccessMessage($message, $redirectUrl) {
    $_SESSION['success_message'] = $message;
    header("Refresh: 2; URL=$redirectUrl");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image_id = $_POST['image_id'];
    $stock = $_POST['stock'];

    if (empty($name) || empty($description) || empty($price) || empty($category_id) || empty($stock)) {
        $error = 'Toate câmpurile sunt obligatorii.';
    } else {
        $sql = "INSERT INTO products (name, description, price, category_id, image_id, stock, user_id) VALUES (?, ?, ?, ?, ?, ?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $description, $price, $category_id, $image_id, $stock, $_SESSION['user_id']]);
        $product_id = $pdo->lastInsertId();
        $stmt->closeCursor();

        showSuccessMessage('Produs adăugat cu succes', 'products.php');
    }
}

$stmt = $pdo->query("SELECT id, name FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adăugare produs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

    <style>
        .error-message {
            display: none;
            color: red;
        }
        .success-message {
            color: green;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorMessage = document.querySelector(".error-message");
            if (errorMessage) {
                errorMessage.style.display = "block";
                setTimeout(function() {
                    errorMessage.style.display = "none";
                }, 2000);
            }
            var successMessage = document.querySelector(".success-message");
            if (successMessage) {
                successMessage.style.display = "block";
                setTimeout(function() {
                    successMessage.style.display = "none";
                }, 2000);
            }
        });
    </script>
</head>
<body>
<h1>Adăugare produs</h1>

<?php if (isset($error)) { ?>
    <p class="error-message"><?php echo $error; ?></p>
<?php } ?>

<?php if (isset($_SESSION['success_message'])) { ?>
    <p class="success-message"><?php echo $_SESSION['success_message']; ?></p>
    <?php unset($_SESSION['success_message']); ?>
<?php } ?>

<form method="post" action="add_products.php">
    <div>
        <label for="name">Nume produs:</label>
        <input type="text" id="name" name="name">
    </div>
    <div>
        <label for="description">Descriere:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
        <label for="price">Preț:</label>
        <input type="number" id="price" name="price" step="0.01">
    </div>
    <div>
        <label for="category_id">Categorie:</label>
        <select id="category_id" name="category_id">
            <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div>
        <label for="image_id">ID imagine:</label>
        <input type="file" id="image_id" name="image_id">
    </div>
    <div>
        <label for="stock">Stoc:</label>
        <input type="number" id="stock" name="stock" min="0">
    </div>
    <button type="submit">Adaugă produs</button>
</form>

</body>
</html>
