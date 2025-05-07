<?php
require_once '../../Controlleur/AppointmentController.php';
$controller = new AppointmentController();
$appointments = $controller->getPendingAppointments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Appointments</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap">
    <link rel="stylesheet" href="../../styles/dentist.css">
</head>
<body>
    <h1>Validate Appointments</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['id']) ?></td>
                    <td><?= htmlspecialchars($appointment['user_name']) ?></td>
                    <td><?= htmlspecialchars($appointment['date']) ?></td>
                    <td><?= htmlspecialchars($appointment['time']) ?></td>
                    <td><?= htmlspecialchars($appointment['status']) ?></td>
                    <td>
                        <?php if ($appointment['status'] == 'pending'): ?>
                            <a href="../../Views/Dentiste/approved_appointments.php?action=validate&id=<?= $appointment['id'] ?>">Validate</a>
                        <?php else: ?>
                            <span>Approved</span>
                        <?php endif; ?>
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
