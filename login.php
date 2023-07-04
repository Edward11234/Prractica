<?php

$is_invalid = false;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user
            WHERE email = '%s'",
            $mysqli -> real_escape_string($_POST["email"]));

    $result = $mysqli ->query($sql);

    $user = $result->fetch_assoc();

    if($user) {
        if(password_verify($_POST["password"],$user["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.php");
            exit;

        }

    }

    $is_invalid = true;
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

    <button>Log in</button>
</form>
</body>