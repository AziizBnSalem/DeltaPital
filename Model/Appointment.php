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
}
?>
