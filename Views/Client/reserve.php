<?php include '../../Controlleur/ReserveController.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Reserve Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 50px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        input {
            margin: 10px 0;
            padding: 8px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
        }
        .error {
            color: red;
            background-color: #f8d7da;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
        }
        .success {
            color: green;
            background-color: #d4edda;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Reserve an Appointment</h1>
    
    <?php if (!empty($error_message)) echo "<p class='error' id='errorMessage'>$error_message</p>"; ?>
    <?php if (isset($_GET['success'])) echo "<p class='success' id='successMessage'>Appointment reserved successfully!</p>"; ?>

    <form method="POST">
        <input type="date" name="date" required>
        <input type="time" name="time" required>
        <button type="submit">Reserve</button>
    </form>

    <script>
        // Function to hide the success or error message after 10 seconds
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            var errorMessage = document.getElementById('errorMessage');
            
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000); // Hide message after 10 seconds
    </script>
</body>
</html>
