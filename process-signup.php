<?php

if(empty($_POST["name"])) {
    die("Introduce-ti un nume !");
}

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Email invalid !");
}

if(strlen($_POST["password"]) < 8){
    die("Parola trebuie sa contina cel putin 8 caractere !");
}

if(! preg_match("/[a-z]/i", $_POST["password"])){
    die("Parola trebuie sa contina cel putin o litera !");
}

if(! preg_match("/[0-9]/i", $_POST["password"])){
    die("Parola trebuie sa contina cel putin o cifra !");
}

if($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Parolele nu corespund !");
}

$password_hash = password_hash($_POST["password"] , PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if(! $stmt->prepare($sql)){
    die("SQL error: ".$mysqli->error);
}
$stmt->bind_param("sss",$_POST["name"],$_POST["email"],$password_hash);

if($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
}else {
    if($mysqli->errno === 1062){
        die("Emailul este folosit !");
    } else {
        die($mysqli->errno. " ". $mysqli->errno);
    }
}

