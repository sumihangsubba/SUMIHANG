<?php
include 'db.php';

// Registration form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate the form data
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    echo "Please fill out all fields";
    exit;
}

// Check if the password and confirm password match
if ($password != $confirm_password) {
    echo "Passwords do not match";
    exit;
}

// Hash the password using a hashing algorithm (e.g., bcrypt)
$hash = password_hash($password, PASSWORD_BCRYPT);

// Insert the user data into the database
$sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $hash);

if ($stmt->execute() === TRUE) {
    $user_id = $stmt->insert_id;
    $default_pic_url = 'default.jpg';
    
    // Insert into the user_profiles table
    $profile_sql = "INSERT INTO user_profiles (user_id, profile_pic_url) VALUES (?, ?)";
    $profile_stmt = $conn->prepare($profile_sql);
    $profile_stmt->bind_param("is", $user_id, $default_pic_url);

    if ($profile_stmt->execute() === TRUE) {
        echo "User created successfully";
    } else {
        echo "Error creating user profile: " . $profile_stmt->error;
    }
    
    $profile_stmt->close();
} else {
    echo "Error creating user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
