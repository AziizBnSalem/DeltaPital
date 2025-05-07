<?php
include_once '../Model/connexion.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use the singleton method to get the database connection
    $database = Database::getInstance();
    $conn = $database->getConnection();

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['password'] == $password) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'super_admin') {
                header("Location: admin/gestionC.php");
                exit();
            } elseif ($user['role'] == 'medecin') {
                header("Location: Dentiste/home.php");
                exit();
            } else {
                header("Location: Client/home.php");
                exit();
            }
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "User not found with the provided name and email.";
    }
}
?>
