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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Navigation Bar Styles */
        nav {
            background-color: #333;
            padding: 15px;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Main Header */
        h1 {
            text-align: center;
            color: #333;
            margin-top: 50px;
            font-size: 2.5em;
        }

        /* Paragraph styling */
        p {
            text-align: center;
            font-size: 1.2em;
            margin-top: 20px;
        }

        /* Logout Button Form */
        form {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1.1em;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                margin-bottom: 15px;
            }

            h1 {
                font-size: 2em;
            }

            p {
                font-size: 1em;
            }

            button {
                width: 100%;
                padding: 15px;
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="modify.php">Modify Profile</a></li>
            <li><a href="reserve.php">Reserve Appointment</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
    <h1>Welcome to Your Client Portal</h1>
    <p>Manage your appointments and personal information.</p>

    <!-- Logout Button -->
    <form action="" method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>
