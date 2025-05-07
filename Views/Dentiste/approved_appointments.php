<?php
require_once '../../Controlleur/AppointmentController.php';
require_once '../../Controlleur/delete_appointment.php';
$controller = new AppointmentController();
$approvedAppointments = $controller->getApprovedAppointments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Appointments</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap">
    <link rel="stylesheet" href="../../styles/dentist.css">
</head>
<body>
    <h1>Approved Appointments</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($approvedAppointments as $appointment): ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['id']) ?></td>
                    <td><?= htmlspecialchars($appointment['user_name']) ?></td>
                    <td><?= htmlspecialchars($appointment['date']) ?></td>
                    <td><?= htmlspecialchars($appointment['time']) ?></td>
                    <td><span>Approved</span></td>
                    <td>
                        <a href="approved_appointments.php?id=<?= htmlspecialchars($appointment['id']) ?>" class="btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="button-container">
    <a href="../../views/Dentiste/home.php"  class="btn-home">Back to Home</a>
    </div>
</body>
</html>
