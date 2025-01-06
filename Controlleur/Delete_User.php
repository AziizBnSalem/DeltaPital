<?php
require_once '../../Model/connexion.php';
require_once '../../Model/User.php';

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Establish database connection
    $db = (new Database())->getConnection();
    $userModel = new User($db);

    // Ensure the user ID is valid (numeric)
    if (is_numeric($userId)) {
        // Call the method to delete the user
        if ($userModel->deleteUser($userId)) {
            echo "User deleted successfully!";
            // Redirect back to the dashboard or another page
            header('Location: gestionC.php');
            exit();
        } else {
            echo "Failed to delete the user. Admins cannot be deleted.";
        }
    }
}
?>
