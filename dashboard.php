<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT u.username, u.email, p.profile_pic_url FROM users u JOIN user_profiles p ON u.id = p.user_id WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found";
    exit();
}

$user = $result->fetch_assoc();
$_SESSION['profile_pic_url'] = $user['profile_pic_url'];

$stmt->close();
$conn->close();

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #D8B241;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
        }

        .dashboard {
            background-color: #E8EBEA;
            padding: 20px;
            margin-top: 70px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .dashboard h2 {
            margin: 0 0 20px;
        }

        .dashboard p {
            margin: 10px 0;
            color: #333;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
        }

        .profile input[type="file"] {
            display: none;
        }

        .logout-button {
            background-color: #ff4b5c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #ff1f3d;
        }

        .upload-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .upload-button:hover {
            background-color: #45a049;
        }

        .message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .message.error {
            background-color: #ff4b5c;
        }
    </style>
</head>
<body>w!!!!!!!!WQ*j
    <div class="navbar">
        Navigation Bar
    </div>
    <div class="dashboard">
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'error') !== false ? 'error' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <div class="profile">
            <img src="<?php echo htmlspecialchars($_SESSION['profile_pic_url']); ?>" alt="Profile Picture" class="profile-pic" id="profile-pic">
            <form id="profile-pic-form" action="upload_profile_pic.php" method="post" enctype="multipart/form-data">
                <input type="file" name="profile_pic" id="file-input" accept="image/*">
                <button type="submit" class="upload-button">Upload</button>
            </form>
        </div>
        <button class="logout-button" onclick="logout()">Logout</button>
    </div>
    <script>
        document.getElementById('profile-pic').addEventListener('click', function() {
            document.getElementById('file-input').click();
        });

        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
    <h2>Welcome to my page!</h2>
       <p>  Here, you can explore various features and functionalities tailored just for you. </p>
     

</html>
