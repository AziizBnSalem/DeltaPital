<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit();
}

// Handle logout request
if (isset($_POST['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../login.php"); // Redirect to login page
    exit();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Home</title>
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
        <h1>Welcome to Your Client Portal</h1>
        <p>Manage your appointments and personal information easily and securely.</p>

        <form method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
