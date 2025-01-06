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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap"> <!-- Modern Google Font -->
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #333;
            background: linear-gradient(rgba(0, 0, 0, 0.86), rgba(126, 132, 140, 0.66)), url("dentistry-concept.png");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
            text-align: center;
        }

        /* Logo Styles */
        .logo-container {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;  /* Increased size */
            height: 150px; /* Increased size */
            border-radius: 50%; /* Make it circular */
            overflow: hidden;
            border: 5px solid #ffffff; /* Optional border around the logo */
        }

        .logo-container img {
            width: 100%;  /* Make the image fill the container */
            height: 100%;
            object-fit: cover; /* Ensures the logo is well fitted and cropped */
        }

        h1 {
            font-size: 2.5em;
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        p {
            font-size: 18px;
            color: #eeeeee;
            margin-bottom: 40px;
            font-weight: 400;
        }

        /* Button Styles */
        .button-container {
            display: flex;
            justify-content: space-between;
            width: 60%;
            max-width: 800px;
        }

        .button-container a {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30%;
            height: 150px;
            background-color:rgba(45, 55, 67, 0.73);
            color: white;
            font-size: 1.5em;
            font-weight: 500;
            border-radius: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-decoration: none;
        }

        .button-container a:hover {
            background-color:rgba(10, 30, 51, 0.56);
            transform: scale(1.1);
        }

        .button-container a:active {
            transform: scale(0.95);
        }

        /* Logout Button */
        form button {
            background-color: #e50914;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 30px;
        }

        form button:hover {
            background-color: #c30708;
            transform: scale(1.05);
        }

        /* Footer */
        footer {
            position: absolute;
            bottom: 20px;
            text-align: center;
            font-size: 14px;
            color: #ffffff;
            opacity: 0.7;
        }

        footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #cccccc;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .button-container {
                flex-direction: column;
                width: 80%;
            }

            .button-container a {
                width: 100%;
                margin-bottom: 20px;
                height: 120px;
                font-size: 1.2em;
            }

            form button {
                padding: 12px 25px;
                font-size: 14px;
            }
        }
    </style>
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
        <a href="./gestionC.php" aria-label="Manage clients">Gestion Client</a>
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
