<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
    $user_id = $_SESSION['user_id'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: dashboard.php");
        exit();
    }

    if ($_FILES["profile_pic"]["size"] > 2000000) {
        $_SESSION['message'] = "Sorry, your file is too large.";
        header("Location: dashboard.php");
        exit();
    }

    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        $sql = "UPDATE user_profiles SET profile_pic_url = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $target_file, $user_id);

        if ($stmt->execute()) {
            $_SESSION['profile_pic_url'] = $target_file;
            $_SESSION['message'] = "Profile picture updated successfully.";
        } else {
            $_SESSION['message'] = "Error updating profile picture: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Sorry, there was an error uploading your file.";
    }
} else {
    $_SESSION['message'] = "No file was uploaded or there was an upload error.";
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
