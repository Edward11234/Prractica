<?php
session_start();

$total=0;

$cart = $_SESSION['cart'] ?? [];

if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    foreach ($cart as $key => $product) {
        if ($product['product_id'] == $product_id) {
            unset($cart[$key]);
            break;
        }
    }
    $_SESSION['cart'] = $cart;
}

if (isset($_POST['add'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=login_db", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT `name`, `price` FROM `products` WHERE id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $product_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product_data && is_array($product_data)) {
            $price = (float)$product_data['price']; // Convert price to a float
            $product_total = $price * $quantity;
            $total += $product_total;

            $product = [
                'product_id' => $product_id,
                'quantity' => $quantity
            ];
            $cart[] = $product;
            $_SESSION['cart'] = $cart;
        }
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

if (isset($_POST['buy_now'])) {
    if (!empty($cart)) {
        $_SESSION['cart'] = [];
        echo "<script>alert('Purchase completed successfully!')</script>";
    } else {
        echo "<script>alert('The shopping cart is empty!')</script>";
    }
}

if (isset($_POST['remove_all'])) {
    $_SESSION['cart'] = [];
    echo "<script>alert('The shopping cart has been emptied!')</script>";
    echo "<script>window.location = 'cart.php'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Dancing+Script" rel="stylesheet">
</head>
<body class="container">
<h1 class="text-center text-danger mb-5" style="font-family: 'Abril Fatface', cursive;"> SHOPPING CART </h1>
<p>Inapoi la <a href="products.php">produse</a></p>

<div class="row">
    <?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=login_db", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT `id`, `name`, `image_url`, `description`, `price` FROM `products` ORDER BY id ASC";
        $stmt = $pdo->query($query);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $num = count($products);

        if ($num > 0) {
            foreach ($products as $product) {
                ?>

                <div class="col-lg-3 col-md-3 col-sm-12">
                    <form method="POST">
                        <div class="card">
                            <h6 class="card-title bg-info text-white p-2 text-uppercase">
                                <?php echo $product['name']; ?>
                            </h6>
                            <div class="card-body">
                                <img src="<?php echo $product['image_url']; ?>" alt="phone" class="img-fluid mb-2">
                                <h6>
                                    <?php echo $product['description']; ?>
                                    <br>
                                    <?php if ($product['price'] !== null) { ?>
                                        <?php echo $product['price']; ?>
                                    <?php } ?>
                                </h6>
                                <input type="text" name="quantity" class="form-control" placeholder="Quantity" value="1">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            </div>
                            <div class="btn-group d-flex">
                                <button class="btn btn-success flex-fill" name="add">Add to cart</button>
                                <button class="btn btn-warning flex-fill text-white" name="buy_now">Buy Now</button>
                            </div>
                        </div>
                    </form>
                </div>


                <?php
            }
        } else {
            echo "<h5>No products available</h5>";
        }
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
    ?>

</div>

<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cart Summary</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    if (!empty($cart)) {
                        foreach ($cart as $product) {
                            $product_id = $product['product_id'];
                            $query = "SELECT `name`, `price` FROM `products` WHERE id = :product_id";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':product_id', $product_id);
                            $stmt->execute();
                            $product_data = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($product_data && is_array($product_data)) {
                                $quantity = $product['quantity'];
                                $price = (float)$product_data['price']; // Convert price to a float
                                $product_total = $price * $quantity;
                                $total += $product_total;
                                ?>

                                <tr>
                                    <td><?php echo $product_data['name']; ?></td>
                                    <td><?php echo $product_data['price']; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td><?php echo $product_total; ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <button class="btn btn-danger btn-sm" name="remove">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products in cart</td></tr>";
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td><strong>Total:</strong></td>
                        <td><?php echo $total; ?></td>
                    </tr>
                    </tfoot>
                </table>
                <form method="POST">
                    <button class="btn btn-danger" name="remove_all">Remove All</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

