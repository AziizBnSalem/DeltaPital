<?php
session_start();

// Use __DIR__ for reliable path resolution
require_once __DIR__ . '/../Model/user.php';

// Initialize messages
$error_message = '';
$success_message = '';

// Redirect if not logged in

$user_id = $_SESSION['id'];
$user = new User();

// Fetch user's current data
$user_data = $user->getUserById($user_id);
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
        if ($user->updateUser($user_id, $name, $email)) {
            $success_message = "Profile updated successfully!";
            $user_data = $user->getUserById($user_id); // Refresh data
        } else {
            $error_message = "Failed to update profile.";
        }
    }
}
?>

