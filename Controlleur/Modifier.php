<?php
session_start();

// Use __DIR__ for reliable path resolution
require __DIR__ . '/../Model/user.php';

// Initialize messages
$error_message = '';
$success_message = '';

// Check if 'id' is set in the session
if (!isset($_SESSION['id'])) {
    // Redirect to login page if the user is not logged in
    header('Location: login.php'); // Adjust the redirection to your login page
    exit();
}

// If 'id' is set, assign it to $id
$id = $_SESSION['id'];
$users = new User();

// Fetch user's current data
$user_data = $users->getUserById($id);
if (!$user_data) {
    echo "User not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    if (empty($name) || empty($email)) {
        $error_message = "Both fields are required.";
    } else {
        if ($users->updateUser($id, $name, $email)) {
            $success_message = "Profile updated successfully!";
            $user_data = $users->getUserById($id); // Refresh data
        } else {
            $error_message = "Failed to update profile.";
        }
    }
}

?>

