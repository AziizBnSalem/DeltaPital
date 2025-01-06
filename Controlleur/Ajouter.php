<?php
class Ajouter {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addClient($data) {
        // Example of how to add a client to the database
        $query = "INSERT INTO clients (name, email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        
        if ($stmt->execute()) {
            echo "Client added successfully!";
        } else {
            echo "Error adding client.";
        }
    }
}
?>
