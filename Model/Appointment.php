<?php
class Appointment {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPendingAppointments() {
        $query = "SELECT a.id, u.name as user_name, a.date, a.time, a.status
                  FROM appointments a
                  JOIN users u ON a.user_id = u.id
                  WHERE a.status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validateAppointment($id) {
        $query = "UPDATE appointments SET status = 'validated' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addAppointment($userId, $date, $time) {
        $query = "INSERT INTO appointments (user_id, date, time) VALUES (:user_id, :date, :time)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        return $stmt->execute();
    }

    public function getClientApprovedAppointments($user_name) {
        $query = "SELECT * FROM approved_appointments 
                 WHERE user_name = :user_name 
                 ORDER BY date, time";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateClientAppointment($id, $user_name, $date, $time) {
        // First check if the new time slot is available
        $query = "SELECT 1 FROM (
                    SELECT date, time FROM appointments WHERE status != 'validated'
                    UNION
                    SELECT date, time FROM approved_appointments WHERE id != :id
                 ) AS all_appointments 
                 WHERE date = :date AND time = :time";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return false; // Time slot is taken
        }

        // Update the appointment if time slot is available
        $query = "UPDATE approved_appointments 
                 SET date = :date, time = :time 
                 WHERE id = :id AND user_name = :user_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        return $stmt->execute();
    }

    public function deleteClientAppointment($id, $user_name) {
        $query = "DELETE FROM approved_appointments 
                 WHERE id = :id AND user_name = :user_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>
