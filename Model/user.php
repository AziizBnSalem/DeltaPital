<?php
require_once 'connexion.php';

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;  // Use the PDO connection passed in the constructor
    }

    // Method to fetch all users
    public function getAllUsers() {
        // SQL query to fetch all users
        $query = "SELECT id, name, email, password, role, created_at, updated_at FROM users";
        
        // Prepare and execute the statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Fetch all results and return them as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get a user by ID
    public function getUserById($id) {
        $query = "SELECT id, name, email FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);  // Use PDO to prepare the statement
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update a user
    public function updateUser($id, $name, $email) {
        $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);  // Use PDO to prepare the statement
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    // Method to check if an email already exists
    public function checkEmailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);  // Use PDO to prepare the statement
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Method to delete a user, with a check for super_admin role
    public function deleteUser($id, $currentUserRole) {
        // Query to get the user's role by ID
        $query = "SELECT role FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the user's role
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if the user exists and if their role is 'admin'
        if ($user && $user['role'] === 'medecin') {
            // If current user is not a super_admin, prevent deletion
            if ($currentUserRole !== 'super_admin') {
                return false;
            }
        }
        
        // SQL query to delete the user
        $query = "DELETE FROM users WHERE id = :id";
        
        // Prepare the query
        $stmt = $this->conn->prepare($query);
        
        // Bind the user ID parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Execute the query and check if it was successful
        return $stmt->execute();
    }
}
?>
