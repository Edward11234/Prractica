<?php

session_start();


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Adăugați produsul în coș
    if (!in_array($product_name, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $product_name;

        $_SESSION['success_message'] = 'Produsul "' . $product_name . '" a fost adăugat cu succes în coș.';
    }

    header("Location: products.php");
    exit;
}

?>
