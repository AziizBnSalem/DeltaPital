<?php include '../../Controlleur/ReserveController.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reserve Appointment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/style.css">
    <style>
        .action-btn.edit {
            background-color: #FFA500;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .action-btn.delete {
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .action-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="reserve.php">Reservation</a>
        <a href="profile.php">Profile</a>
    </nav>

    <div class="container">
        <h1>Reserve an Appointment</h1>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'timeslot_taken'): ?>
            <p class='error' id='errorMessage'>This time slot is already taken. Please choose another time.</p>
        <?php endif; ?>
        <?php if (isset($_GET['success'])) echo "<p class='success' id='successMessage'>Appointment reserved successfully!</p>"; ?>

        <form method="POST" action="../../Controlleur/ReserveController.php">
            <input type="date" name="date" required>
            <input type="time" name="time" required>
            <button type="submit">Reserve</button>
        </form>

        <form action="../Client/home.php" method="get">
            <button type="submit">Back Home</button>
        </form>

        <div class="table-container">
            <table>
                <caption>My Reservations</caption>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($approved_appointments)): ?>
                        <?php foreach ($approved_appointments as $res): ?>
                            <tr>
                                <td><?= htmlspecialchars($res['date']) ?></td>
                                <td><?= htmlspecialchars($res['time']) ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <button type="button" onclick="showEditForm(<?= $res['id'] ?>, '<?= $res['date'] ?>', '<?= $res['time'] ?>')" class="action-btn edit">Modify</button>
                                    </form>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="appointment_id" value="<?= $res['id'] ?>">
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3">No reservations found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditForm()">&times;</span>
            <h2>Modify Appointment</h2>
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="appointment_id" id="edit_appointment_id">
                <div class="form-group">
                    <label for="edit_date">Date:</label>
                    <input type="date" name="new_date" id="edit_date" required>
                </div>
                <div class="form-group">
                    <label for="edit_time">Time:</label>
                    <input type="time" name="new_time" id="edit_time" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="save-btn">Save Changes</button>
                    <button type="button" class="cancel-btn" onclick="closeEditForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .save-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .save-btn:hover, .cancel-btn:hover {
            opacity: 0.9;
        }
    </style>

    <script>
        setTimeout(() => {
            const msg = document.getElementById('successMessage') || document.getElementById('errorMessage');
            if (msg) msg.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>

<script>
    function showEditForm(id, date, time) {
        document.getElementById('editModal').style.display = 'block';
        document.getElementById('edit_appointment_id').value = id;
        document.getElementById('edit_date').value = date;
        document.getElementById('edit_time').value = time;
    }

    function closeEditForm() {
        document.getElementById('editModal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const messages = document.querySelectorAll('.error, .success');
            messages.forEach(msg => {
                if (msg) msg.style.display = 'none';
            });
        }, 5000);
    });
</script>

<style>
    .error, .success {
        background-color: #ffebee;
        color: #c62828;
        padding: 10px;
        border-radius: 4px;
        margin: 20px auto;
        text-align: center;
        max-width: 500px;
        width: 90%;
        display: block;
    }

    .success {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
</style>
