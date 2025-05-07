<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentiste Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap">
    <link rel="stylesheet" href="../../styles/dentist.css">
</head>
<body>

    <!-- Logo Section -->
    <div class="logo-container">
        <img src="logo.jpeg" alt="Logo">
    </div>
    <br>

    <h1>Welcome to the Dentist Portal</h1>
    <p>Your one-stop solution for managing appointments and clients with efficiency and professionalism.</p>

    <div class="button-container">
        <a href="./validate_appointments.php" aria-label="Validate appointments">Validate Appointments</a>
        <a href="./approved_appointments.php" aria-label="More Features">Approved Clients</a> <!-- Placeholder for another page -->
    </div>

    <form method="POST">
        <button type="submit" name="logout" aria-label="Logout">Logout</button>
    </form>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 Dentist Lab | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

</body>
</html>
