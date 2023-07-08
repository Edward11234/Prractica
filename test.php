<?php
//@todo: Schimba query-urile din app
// user logat
// validare daca e seller -> redirect cu eroare
// produs
// validare daca produsul e al user-ului

$pdo = require './database/database.php';

$statement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
$statement->execute(['email' => 'ioan.andrei97@gmail.com']);
$result = $statement->fetch();

print_r($result);

//