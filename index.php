<?php
// Start or resume a session
session_start();

// Include the configuration file
require_once 'config.php';

// If the user is already logged in, redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}

// Handle signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password]);

    $signupSuccess = "Account created successfully. You can now log in.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login/Signup Page</title>
</head>
<body>

<div class="container">
    <div class="form-container">
        <form action="index.php" method="post">
            <h2>Login</h2>
            <?php if (isset($loginError)) : ?>
                <p class="error"><?php echo $loginError; ?></p>
            <?php endif; ?>
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <form action="index.php" method="post">
            <h2>Signup</h2>
            <?php if (isset($signupSuccess)) : ?>
                <p class="success"><?php echo $signupSuccess; ?></p>
            <?php endif; ?>
            <label for="new_username">New Username:</label>
            <input type="text" name="new_username" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit" name="signup">Signup</button>
        </form>
    </div>
</div>

</body>
</html>

