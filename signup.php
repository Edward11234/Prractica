<?php
session_start();

if (isset($_SESSION['success_message'])) {
    echo '<p class="success-message">' . $_SESSION['success_message'] . '</p>';
    unset($_SESSION['success_message']);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["name"])) {
        addError("Introduceți un nume!");
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        addError("Email invalid!");
    }

    if (strlen($_POST["password"]) < 8) {
        addError("Parola trebuie să conțină cel puțin 8 caractere!");
    }

    if (!preg_match("/[a-z]/i", $_POST["password"])) {
        addError("Parola trebuie să conțină cel puțin o literă!");
    }

    if (!preg_match("/[0-9]/i", $_POST["password"])) {
        addError("Parola trebuie să conțină cel puțin o cifră!");
    }

    if ($_POST["password"] !== $_POST["password_confirmation"]) {
        addError("Parolele nu corespund!");
    }

    if (count($_SESSION['signup_form_errors'] ?? []) > 0) {
        redirectBack();
    } else {
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $role = $_POST["role"]; // Obțineți rolul din formular

        $pdo = require __DIR__ . "/database/database.php";

        $checkEmailStmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $checkEmailStmt->bindValue(':email', $_POST["email"]);
        $checkEmailStmt->execute();
        $existingUser = $checkEmailStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            addError("Emailul este folosit!");
            redirectBack();
        } else {
            $sql = "INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            if (!$stmt) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }

            if ($stmt->execute([$_POST["name"], $_POST["email"], $password_hash, $role])) {
                $_SESSION['success_message'] = 'Registered Successfully';
                redirectBack();
            } else {
                die($stmt->errorInfo()[2]);
            }
        }
    }
}

function redirectBack() {
    header('Location: signup.php');
    exit();
}

function addError($error) {
    if (!isset($_SESSION['signup_form_errors'])) {
        $_SESSION['signup_form_errors'] = [];
    }
    $_SESSION['signup_form_errors'][] = $error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Signup</title>
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
                }, 3000);
            }
        });
    </script>
</head>
<body>
<h1>Signup</h1>

<?php
if (isset($_SESSION['signup_form_errors']) && count($_SESSION['signup_form_errors']) > 0) {
    foreach ($_SESSION['signup_form_errors'] as $error) {
        echo '<p class="error-message">' . htmlspecialchars($error) . '</p>';
    }
    unset($_SESSION['signup_form_errors']);
}
?>

<form action="signup.php" method="post" novalidate>
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
    </div>

    <div>
        <label for="password_confirmation">Repeat Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
    </div>

    <div>
        <label for="role">Role</label>
        <select id="role" name="role">
            <option value="customer">Customer</option>
            <option value="seller">Seller</option>
        </select>
    </div>

    <button type="submit">Sign up</button> <p>Acum te poți loga <a href="login.php">aici</a></p>
</form>

</body>
</html>
