<?php
session_start();
if (isset($_SESSION["user_id"])) {
    $pdo = require __DIR__ . "/database/database.php";

    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION["user_id"]);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
<?php include 'html/navbar.php'; ?>
<div class="container">
    <h1>Home</h1>

    <?php if (isset($user)): ?>
        <p class="welcome-message">Salut, <?= htmlspecialchars($user["name"]) ?></p>
    <?php else: ?>
        <p><a href="login.php">Log in</a> or <a href="signup.php">Sign up</a></p>
    <?php endif; ?>
</div>

</body>
</html>

