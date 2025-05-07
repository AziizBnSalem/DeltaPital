<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Model/connexion.php';
require_once __DIR__ . '/../Model/Appointment.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    die("You must be logged in to reserve an appointment.");
}

// Get the database connection and create appointment instance
$database = Database::getInstance();
$conn = $database->getConnection();
$appointment = new Appointment($conn);

// Handle new appointment creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    if (isset($_POST['date']) && isset($_POST['time'])) {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $user_name = $_SESSION['user_name'];

        // Check if timeslot is available
        $query = "SELECT COUNT(*) FROM (
            SELECT date, time FROM appointments WHERE status != 'validated'
            UNION
            SELECT date, time FROM approved_appointments
        ) AS all_appointments 
        WHERE date = :date AND time = :time";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            header("Location: ../Views/Client/reserve.php?error=timeslot_taken");
            exit;
        }

        // Create the appointment
        $query = "INSERT INTO appointments (user_name, date, time, status) 
                 VALUES (:user_name, :date, :time, 'pending')";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        
        if ($stmt->execute()) {
            header("Location: ../Views/Client/reserve.php?success=true");
        } else {
            header("Location: ../Views/Client/reserve.php?error=failed");
        }
        exit;
    }
}

// Handle delete and update actions
if (isset($_POST['action'])) {
    $user_name = $_SESSION['user_name'];
    
    if ($_POST['action'] === 'delete' && isset($_POST['appointment_id'])) {
        if ($appointment->deleteClientAppointment($_POST['appointment_id'], $user_name)) {
            header("Location: reserve.php?success=deleted");
            exit;
        }
    } elseif ($_POST['action'] === 'update' && isset($_POST['appointment_id'])) {
        $result = $appointment->updateClientAppointment(
            $_POST['appointment_id'],
            $user_name,
            $_POST['new_date'],
            $_POST['new_time']
        );
        if ($result) {
            header("Location: reserve.php?success=updated");
        } else {
            header("Location: reserve.php?error=timeslot_taken");
        }
        exit;
    }
}

// Get client's approved appointments
$approved_appointments = $appointment->getClientApprovedAppointments($_SESSION['user_name']);
?>