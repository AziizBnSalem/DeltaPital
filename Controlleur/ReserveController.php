<?php
session_start();
require_once '../../Model/connexion.php'; // Ensure this file contains the connection logic
require_once '../../Model/Appointment.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    die("You must be logged in to reserve an appointment.");
}

// Get the database connection using the Singleton pattern
$database = Database::getInstance();
$conn = $database->getConnection(); // This will return the connection object

// Check if $conn is defined and connected
if (!$conn) {
    die("Database connection failed.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize it
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $user_name = htmlspecialchars($_SESSION['user_name']); // Assuming the user's name is stored in the session

    // Ensure that both date and time are not empty
    if (empty($date) || empty($time)) {
        $error_message = "Please provide both date and time for the appointment.";
    } else {
        // Check if the appointment time already exists for the same date
        $query = "SELECT * FROM appointments WHERE date = :date AND time = :time AND status != 'validated'";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error_message = "The selected appointment time is already reserved.";
        } else {
            // Insert the reservation into the database with the user's name
            $query = "INSERT INTO appointments (user_name, date, time, status) VALUES (:user_name, :date, :time, 'pending')";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':time', $time);

            if ($stmt->execute()) {
                // Redirect to the appointment page with a success message
                header("Location: reserve.php?success=true");
                exit; // Ensure no further code is executed
            } else {
                $error_message = "Error reserving the appointment. Please try again.";
            }
        }
    }
}
?> 
