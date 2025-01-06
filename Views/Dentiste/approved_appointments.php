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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        .button-container {
            margin-top: 20px;
        }
        .btn-home {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
        }
        .btn-home:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 10px;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
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
