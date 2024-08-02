<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM users WHERE LOWER(email) = LOWER(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password_hash']; // Changed to password_hash to match your table structure

            if (password_verify($password, $stored_password)) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                // Redirect to the dashboard or another page after successful login
                header("Location: dashboard.php");
                exit(); // Ensure no further code is executed after redirection
            } else {
                echo "Invalid email or password.";
                exit(); // Ensure no further code is executed after outputting error message
            }
        } else {
            echo "No user found with that email.";
            exit(); // Ensure no further code is executed after outputting error message
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit(); // Ensure no further code is executed after outputting error message
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var fields = document.querySelectorAll("input[type='text'], input[type='password']");
        
        fields.forEach(function(field) {
            // Disable paste
            field.addEventListener('paste', function(e) {
                e.preventDefault();
            });
            // Disable copy
            field.addEventListener('copy', function(e) {
                e.preventDefault();
            });
            // Disable cut
            field.addEventListener('cut', function(e) {
                e.preventDefault();
            });
            // Disable context menu (right-click)
            field.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
            // Disable common keyboard shortcuts (e.g., Ctrl+V)
            field.addEventListener('keydown', function(e) {
                if ((e.ctrlKey && (e.key === 'v' || e.key === 'c' || e.key === 'x')) || 
                    (e.shiftKey && e.key === 'Insert') || 
                    (e.key === 'Insert' && e.shiftKey)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
</head>
<body>
<form method="POST" action="">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
