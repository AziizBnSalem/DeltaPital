<?php
require_once '../../Model/user.php';
// ModifierController.php
class ModifierController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db->getConnection();  // Get the PDO connection directly here
        $this->user = new User($this->db);  // Pass the PDO instance to User class
    }

    // Fetch user data by user ID
    public function getUserData($userId) {
        if (!$userId) {
            return false;  // Return false if no user ID is provided
        }

        // Get user data from the User class
        $userData = $this->user->getUserById($userId);

        if (!$userData) {
            return false;  // If no data found, return false
        }

        return $userData;
    }

    // Update the user's profile with new data
    public function updateProfile($userId, $data) {
        if (empty($data['name']) || empty($data['email'])) {
            return "Both fields are required.";  // Ensure both fields are filled
        }

        // Sanitize the inputs for security
        $name = htmlspecialchars(trim($data['name']));
        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);

        if (!$email) {
            return "Invalid email format.";  // Validate the email format
        }

        // Call the updateUser function in the User class to update profile
        $updated = $this->user->updateUser($userId, $name, $email);

        if ($updated) {
            return "Profile updated successfully!";
        } else {
            return "Failed to update profile.";
        }
    }
}

?>
