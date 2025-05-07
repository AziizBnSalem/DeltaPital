<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reserve Appointment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/style.css">
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="reserve.php">Reservation</a>
        <a href="profile.php">Profile</a>
    </nav>

    <div class="container">
        <h1>Reserve an Appointment</h1>

        <?php if (!empty($error_message)) echo "<p class='error' id='errorMessage'>$error_message</p>"; ?>
        <?php if (isset($_GET['success'])) echo "<p class='success' id='successMessage'>Appointment reserved successfully!</p>"; ?>

        <form method="POST">
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
                    <tr><th>Date</th><th>Time</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($reservations)): ?>
                        <?php foreach ($reservations as $res): ?>
                            <tr>
                                <td><?= htmlspecialchars($res['date']) ?></td>
                                <td><?= htmlspecialchars($res['time']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="2">No reservations found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const msg = document.getElementById('successMessage') || document.getElementById('errorMessage');
            if (msg) msg.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>
