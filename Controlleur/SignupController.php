<?php
// Include database connection
include_once '../Model/connexion.php';

// Initialize error message
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['cpassword'];

    // Validate passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Create database connection
        $database = Database::getInstance();
        $conn = $database->getConnection();

        // Check if the name or email already exists
        $query = "SELECT * FROM users WHERE name = :name OR email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error_message = "Name or email is already taken.";
        } else {
            // Insert user into the database (no password hashing)
            $query = "INSERT INTO users (name, email, password, role, created_at, updated_at) 
                      VALUES (:name, :email, :password, 'user', NOW(), NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);  // Storing plain password

            if ($stmt->execute()) {
                // Redirect to login page after successful signup
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error creating account. Please try again.";
            }
        }
    }
}
?>
