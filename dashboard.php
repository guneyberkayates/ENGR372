<?php
// Start or resume a session
session_start();

// Include the configuration file
require_once 'config.php';

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch user data
$userID = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for updating personal information
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
    $fullName = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Update user information in the database
    $sql = "UPDATE users SET full_name = ?, email = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fullName, $email, $userID]);

    // Redirect to the dashboard with a success message
    header('Location: dashboard.php?update=success');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Welcome, <?php echo $user['username']; ?>!</h2>

        <!-- Display success message if applicable -->
        <?php if (isset($_GET['update']) && $_GET['update'] === 'success') : ?>
            <p class="success">Personal information updated successfully!</p>
        <?php endif; ?>

        <!-- Display user information -->
        <p><strong>Full Name:</strong> <?php echo isset($user['full_name']) ? $user['full_name'] : ''; ?></p>
        <p><strong>Email:</strong> <?php echo isset($user['email']) ? $user['email'] : ''; ?></p>

        <!-- Form for updating personal information -->
        <form action="dashboard.php" method="post">
            <h3>Update Personal Information</h3>
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" value="<?php echo isset($user['full_name']) ? $user['full_name'] : ''; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
            <button type="submit" name="update_info">Update Information</button>
        </form>

        <!-- Logout button -->
<!-- Logout button -->
<form action="logout.php" method="post">
    <button type="submit" name="logout">Logout</button>
</form>

    </div>
</div>

</body>
</html>
