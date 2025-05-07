<?php
include '../Controlleur/LoginController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80%;
            max-width: 1000px;
        }

        /* Logo Styles */
        .logo-container {
            position: absolute;
            top: 20px;
            right: 50px;
            width: 120px;  /* Adjust logo size */
            height: 120px; /* Adjust logo size */
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #007bff; /* Optional border for logo */
        }

        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Form Styles */
        .form-container {
            background-color: white;
            padding: 40px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-left: 20px;
            text-align: center;
        }

        .form-container h1 {
            color: #007bff;
            margin-bottom: 20px;
        }

        form input[type="text"], 
        form input[type="email"], 
        form input[type="password"] {
            width: 94%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Link Styling */
        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Error Message Styling */
        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
        }

        p {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Form Section -->
        <div class="form-container">
            <h1>Login</h1>
            
            <!-- Display error messages if any -->
            <?php
            if (!empty($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>

        <!-- Logo Section -->
        <div class="logo-container">
            <img src="Dentiste/logo.jpeg" alt="Logo">
        </div>
    </div>

</body>
</html>
