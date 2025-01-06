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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
            font-size: 2em;
            color: #333;
        }
        p {
            font-size: 1.1rem;
            text-align: center;
            margin: 15px 0;
            color: #555;
        }
        a {
            text-align: center;
            display: block;
            margin-top: 20px;
            font-size: 1.1rem;
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8em;
            }
            p, a {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <h1>Your Profile</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($user_data['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['email']); ?></p>

    <a href="modify.php">Modify Profile</a>
</body>
</html>
