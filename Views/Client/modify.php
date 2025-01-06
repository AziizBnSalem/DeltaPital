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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Profile</title>
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
            color: #333;
            margin-top: 50px;
            font-size: 2em;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            margin-top: 15px;
            font-size: 1rem;
            font-weight: bold;
        }

        input {
            padding: 10px;
            width: 100%;
            margin-top: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        button {
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
            text-align: center;
            font-size: 1.1rem;
            margin-top: 15px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8em;
            }

            form {
                width: 90%;
            }

            input {
                font-size: 1rem;
            }

            button {
                padding: 10px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <h1>Modify Your Profile</h1>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required />

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
