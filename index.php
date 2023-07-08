<?php

session_start();
if(isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database/database.php";

    $sql = "SELECT * FROM user 
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result -> fetch_assoc();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>Home</h1>

<?php if (isset($user)) : ?>
  <p>Salut <?= htmlspecialchars ($user["name"])?> </p>
  <p><a href="logout.php">Log out</a></p>
  <p><a href="add_products.php">Adauga produs</a></p>
<?php else: ?>
  <p><a href="login.php">Log in</a> or <a href="signup.php">Sign up</a></p>
<?php endif; ?>


</body>

</html>
