<?php
session_start();  // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your profile.";  // Show a message if user is not logged in
    exit();  // Stop further script execution if the user is not logged in
}

require_once '../../Model/connexion.php';
require_once '../../Model/user.php';

// Instantiate Database and User objects
$db = Database::getInstance()->getConnection(); // Get the DB connection
$user = new User($db);

// Fetch user data using the ID from the session
$user_data = $user->getUserById($_SESSION['user_id']);

// Check if user data was found
if ($user_data === false) {
    echo "User not found!";
    exit();  // Stop further script execution if user is not found
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Profile</title>
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
        <h1>Your Profile</h1>
        <p><strong>Name:</strong> <?= htmlspecialchars($user_data['name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user_data['email']); ?></p>
    </div>
</body>
</html>
