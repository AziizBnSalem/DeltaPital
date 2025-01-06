<?php
require_once '../../Model/connexion.php';
require_once '../../Model/Appointment.php';

// Check if the appointment ID is provided in the URL
if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    // Create an instance of AppointmentController
    $controller = new AppointmentController();

    // Call the method to delete the appointment
    if ($controller->deleteAppointment($appointmentId)) {
        echo "Appointment deleted successfully!";
        // Redirect back to the list of approved appointments
        header('Location: approved_appointments.php');
        exit();
    } else {
        echo "Failed to delete the appointment.";
    }
}
?>
