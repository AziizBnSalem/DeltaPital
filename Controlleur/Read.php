<?php
class Read {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserById($id) {
        // Fetch the user's details by their ID
        $query = "SELECT id, name, email FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Ensure it returns the fetched data correctly
    }
}

?>
