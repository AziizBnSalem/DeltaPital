<?php
session_start();
require_once '../../Controlleur/ModifierController.php';
require_once '../../Model/connexion.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User is not logged in.";
    exit();
}

// Initialize database connection and controller
$db = Database::getInstance();
$controller = new ModifierController($db);

// Handle form submission message
$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user profile
    $message = $controller->updateProfile($_SESSION['user_id'], $_POST);
}

// Fetch the user data to populate the form
$user_data = $controller->getUserData($_SESSION['user_id']);
if (!$user_data) {
    echo "Error: Unable to fetch user data.";
    exit();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/style.css">
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="reserve.php">Reservation</a>
        <a href="profile.php">Profile</a>
    </nav>

    <div class="container">
        <h1>Modify Your Profile</h1>

        <?php if ($message): ?>
            <p class="success"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($user_data['name']); ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user_data['email']); ?>" required>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
