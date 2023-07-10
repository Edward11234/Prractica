<?php
session_start();
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pdo = require __DIR__ . "/database/database.php";


    $checkEmailStmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = :email");
    $checkEmailStmt->bindValue(':email', $_POST["email"]);
    $checkEmailStmt->execute();
    $existingUser = $checkEmailStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        if (password_verify($_POST["password"], $existingUser["password_hash"])) {
            // Autentificare reușită
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $existingUser["id"];
            header("Location: index.php");
            exit;
        } else {
            // Parolă incorectă
            $is_invalid = true;
        }
    } else {
        // Utilizatorul nu există
        $is_invalid = true;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Title</title>
</head>
<body>
<!-- de aici in sus e top html -->
 <h1>Login</h1>

 <?php if($is_invalid):?>
    <em>Invalid Login</em>
 <?php endif; ?>

<form method="post">
    <label for="email">email</label>
    <input type="email" id="email" name="email"
            value="<?=htmlspecialchars($_POST["email"] ?? "")?>">

    <label for="password">password</label>
    <input type="password" id="password" name="password">
    <p>Daca nu ai inca cont apasa <a href="signup.php">aici</a></p>

    <button>Log in</button>
</form>
<!-- de aici in jos e bottom html -->
</body>