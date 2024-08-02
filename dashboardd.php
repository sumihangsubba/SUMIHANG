<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        :root {
            --bg-color-light: #f0f0f0; /* Light mode background */
            --text-color-light: #333; /* Light mode text color */
            --bg-color-dark: #333; /* Dark mode background */
            --text-color-dark: #f0f0f0; /* Dark mode text color */
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
            background-color: var(--bg-color-light);
            color: var(--text-color-light);
        }

        body.dark-mode {
            background-color: var(--bg-color-dark);
            color: var(--text-color-dark);
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

        .container {
            display: flex;
            height: calc(100vh - 50px);
            width: 100%;
            margin-top: 50px; /* Adjust for navbar height */
        }

        .dashboard {
            background-color: #fff;
            padding: 20px;
            margin-top:20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: auto;
            top: 50px;
            bottom: 0;
            left: 0;
        }

        .profile {
            margin-bottom: 20px;
            position: relative;
            text-align: center;
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

        #logout-button {
            background-color: #ff4b5c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: auto;
        }

        #logout-button:hover {
            background-color: #ff1f3d;
        }

        .user-info {
            text-align: center;
        }

        .user-info h2 {
            margin: 10px 0 5px 0;
        }

        .user-info p {
            margin: 0;
            color: #666;
        }

        .info-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .info-box img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        Navigation Bar
    </div>
    <div class="container">
        <div class="dashboard">
            <div class="profile">
                <img src="profile.jpg" alt="Profile Picture" class="profile-pic" id="profile-pic">
                <input type="file" id="file-input" accept="image/*">
            </div>
            <div class="user-info">
                <h2 id="username">Sumihang Subba</h2>
                <p id="user-email">sumihang.subba@gmail.com</p>
            </div>
            <button id="logout-button">Logout</button>
        </div>
    </div>
    <script>
        // Function to toggle dark mode
        function toggleDarkMode() {
            const body = document.body;
            body.classList.toggle('dark-mode');

            // Store preference in localStorage
            const isDarkMode = body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
        }

        // Check if user has previously selected dark mode
        window.onload = function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
            }
        };

        // Listen for right-click to toggle dark mode
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault(); // Prevent the default context menu

            toggleDarkMode(); // Toggle dark mode
        });
        
        // Load the image from localStorage if it exists
        const storedImage = localStorage.getItem('profilePic');
        if (storedImage) {
            document.getElementById('profile-pic').src = storedImage;
        }

        document.getElementById('profile-pic').addEventListener('click', function() {
            document.getElementById('file-input').click();
        });

        document.getElementById('file-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageDataUrl = e.target.result;
                    document.getElementById('profile-pic').src = imageDataUrl;
                    localStorage.setItem('profilePic', imageDataUrl);  // Save the image to localStorage
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('logout-button').addEventListener('click', function() {
            alert('You have logged out.');
            window.location.href = 'intro.html'; // Example redirection to a login page
        });
    </script>
</body>
</html>
