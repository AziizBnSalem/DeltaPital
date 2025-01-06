<?php
require_once '../../Model/connexion.php';
require_once '../../Model/Appointment.php';

class AppointmentController {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Get all pending appointments
    public function getPendingAppointments() {
        $query = "SELECT * FROM appointments WHERE status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteAppointment($appointmentId) {
        // SQL query to delete the appointment from the approved_appointments table
        $query = "DELETE FROM approved_appointments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $appointmentId, PDO::PARAM_INT);
    
        // Execute the query and check if it was successful
        return $stmt->execute();
    }
    

    // Validate appointment (move to approved table and update status)
    public function validateAppointment($appointmentId) {
        // Get the appointment details before moving it to the approved table
        $query = "SELECT * FROM appointments WHERE id = :id AND status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $appointmentId);
        $stmt->execute();
        $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($appointment) {
            // Insert the validated appointment into the approved_appointments table
            $insertQuery = "INSERT INTO approved_appointments (user_name, date, time, status) 
                            VALUES (:user_name, :date, :time, 'approved')";
            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bindParam(':user_name', $appointment['user_name']);
            $stmt->bindParam(':date', $appointment['date']);
            $stmt->bindParam(':time', $appointment['time']);
            $stmt->execute();

            // Delete from pending appointments after moving to approved
            $deleteQuery = "DELETE FROM appointments WHERE id = :id";
            $stmt = $this->conn->prepare($deleteQuery);
            $stmt->bindParam(':id', $appointmentId);
            $stmt->execute();

            return true;
        }
        return false;
    }

    // Get all approved appointments
    public function getApprovedAppointments() {
        $query = "SELECT * FROM approved_appointments";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


// Handle the validation action
if (isset($_GET['action']) && $_GET['action'] == 'validate' && isset($_GET['id'])) {
    $appointmentId = $_GET['id'];
    $controller = new AppointmentController();

    // Validate the appointment (move it to approved)
    if ($controller->validateAppointment($appointmentId)) {
        header('Location: validate_appointments.php'); // Redirect back to the list of appointments
        exit;
    } else {
        echo "Failed to validate the appointment.";
    }
}
?>
