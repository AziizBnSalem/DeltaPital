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

<?php
require_once '../../Controlleur/Delete_User.php';

require_once '../../Model/connexion.php';
$db = (new Database())->getConnection();

require_once '../../Model/User.php';
$userModel = new User($db);
$users = $userModel->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h1 {
            color: #004c8c;
            margin-top: 50px;
            font-size: 2.5em;
            text-transform: uppercase;
        }
        table {
            width: 85%;
            margin: 40px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #e0e0e0;
        }
        th {
            background-color: #007bff;
            color: white;
            font-size: 1.1em;
            font-weight: 500;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #eef5fb;
        }
        td {
            font-size: 1.1em;
            color: #333;
        }
        .btn-home {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        .btn-home:hover {
            background-color: #0056b3;
        }
        form button {
            background-color: #e50914;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 30px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 40px;
        }
        form button:hover {
            background-color: #c30708;
            transform: scale(1.05);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .btn-container {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Management Dashboard</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['password']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($user['updated_at']); ?></td>
                    <td>
                        <a href="gestionC.php?id=<?php echo $user['id']; ?>" class="btn-home" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="btn-container">
            <form method="POST">
                <button type="submit" name="logout" aria-label="Logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
