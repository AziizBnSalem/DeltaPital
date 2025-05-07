<?php
require_once __DIR__ . '../../Model/connexion.php';
require_once __DIR__ . '../../Model/Appointment.php';

class AppointmentController {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Get all pending appointments
    public function getPendingAppointments() {
        $query = "SELECT a.id, a.user_name, a.date, a.time, a.status
                 FROM appointments a
                 WHERE a.status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteAppointment($appointmentId) {
        $query = "DELETE FROM approved_appointments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $appointmentId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function validateAppointment($appointmentId) {
        try {
            $this->conn->beginTransaction();

            // Get the appointment details
            $query = "SELECT * FROM appointments WHERE id = :id AND status = 'pending'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $appointmentId, PDO::PARAM_INT);
            $stmt->execute();
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($appointment) {
                // Insert into approved_appointments
                $insertQuery = "INSERT INTO approved_appointments (user_name, date, time, status) 
                              VALUES (:user_name, :date, :time, 'approved')";
                $stmt = $this->conn->prepare($insertQuery);
                $stmt->bindParam(':user_name', $appointment['user_name']);
                $stmt->bindParam(':date', $appointment['date']);
                $stmt->bindParam(':time', $appointment['time']);
                $stmt->execute();

                // Delete from appointments
                $deleteQuery = "DELETE FROM appointments WHERE id = :id";
                $stmt = $this->conn->prepare($deleteQuery);
                $stmt->bindParam(':id', $appointmentId);
                $stmt->execute();

                $this->conn->commit();
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Get all approved appointments
    public function getApprovedAppointments() {
        $query = "SELECT * FROM approved_appointments";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add this new method for creating appointments
    public function createAppointment($user_name, $date, $time) {
        try {
            // Insert directly into appointments
            $query = "INSERT INTO appointments (user_name, date, time, status) 
                     VALUES (:user_name, :date, :time, 'pending')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':time', $time);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function isTimeSlotAvailable($date, $time) {
        $query = "SELECT COUNT(*) FROM appointments 
                  WHERE date = :date AND time = :time";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }
}

// Add this code at the bottom of the file, before the closing PHP tag
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $controller = new AppointmentController();
    
    if (isset($_POST['date']) && isset($_POST['time']) && isset($_SESSION['user_name'])) {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $user_name = $_SESSION['user_name'];

        if ($controller->isTimeSlotAvailable($date, $time)) {
            if ($controller->createAppointment($user_name, $date, $time)) {
                header("Location: reserve.php?success=true");
                exit;
            } else {
                header("Location: reserve.php?error=failed");
                exit;
            }
        } else {
            header("Location: reserve.php?error=timeslot_taken");
            exit;
        }
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
