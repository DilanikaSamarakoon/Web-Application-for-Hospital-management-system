<?php
// Database connection settings
$host = "localhost";
$username = "root"; // Use your database username
$password = "";     // Use your database password
$database = "care_compass";

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all feedback from the database
$sql = "SELECT name, email, feedback, created_at FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="view_feedback.css">
    
    <title>View Feedback | Care Compass Hospitals</title>
    <style>
       .search-container {
    position: relative;
    display: flex;
    align-items: center;
}

#searchBar {
    width: 250px;
    padding: 10px 15px;
    border: 2px solid #4CAF50;
    border-radius: 20px;
    font-size: 16px;
    outline: none;
    transition: all 0.3s ease-in-out;
    background-color: white;
}

#searchBar::placeholder {
    color: gray;
    opacity: 1; /* Ensure placeholder text is visible */
}

#searchBar:focus {
    width: 300px;
    border-color: #2E8B57;
}

    </style>
</head>
<body>
<div class="wrapper">
    <!-- Navigation Bar -->
    <nav class="nav">
        <div class="nav-logo">
            <p>Care Compass Hospitals</p>
            <div class="search-container">
                    <input type="text" id="searchBar" onkeyup="searchMenu()" placeholder="Search...">
                   
                </div>
        </div>
        <ul class="nav-menu">
        <li><a href="index.html" class="link">Home</a></li>
                    <li><a href="contact.html" class="link">Contact Us</a></li>
                    <li><a href="services.html" class="link active">Services</a></li>
                    <li><a href="about.html" class="link">About Us</a></li>
                    <li><a href="emergency information.html" class="link">Emergency Information</a></li>
                    <li><a href="vieww_feedback.php" class="link">Feedback</a></li>
        </ul>
        <div class="nav-button">
                <button class="btn white-btn" id="loginBtn" onclick="login()">Sign In</button>
                <button class="btn" id="registerBtn" onclick="register()">Sign Up</button>
            </div>
            <div class="nav-menu-btn">
                <i class="bx bx-menu" onclick="myMenuFunction()"></i>
            </div>
        </nav>

        <script>
    function myMenuFunction() {
        var i = document.getElementById("navMenu");

        if(i.className === "nav-menu") {
            i.className += " responsive";
        } else {
            i.className = "nav-menu";
        }
    }

    // Function to handle login
    function login() {
        // Redirect to the home page after "Sign In" button click
        window.location.href = "index.html"; // Adjust this if needed
    }

    // Function to handle registration
    function register() {
        // Redirect to the home page after "Sign Up" button click
        window.location.href = "index.html"; // Adjust this if needed
    }
    function searchMenu() {
            let input = document.getElementById("searchBar").value.toLowerCase();
            let links = document.querySelectorAll("#menuList li");
            links.forEach(link => {
                let text = link.textContent.toLowerCase();
                link.style.display = text.includes(input) ? "block" : "none";
            });
        }
</script>
    <!-- Page Header -->
    <header class="page-header">
        <h1>Patient Feedback</h1>
        <p>Read what our patients have to say about us.</p>
    </header>

    <!-- Feedback Display Section -->
    <section class="feedback-display-section">
        <h2>Recent Feedback</h2>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='feedback-item'>";
                echo "<h3>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['email']) . ")</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row['feedback'])) . "</p>";
                echo "<small>Submitted on: " . $row['created_at'] . "</small>";
                echo "</div>";
            }
        } else {
            echo "<p>No feedback available.</p>";
        }
        ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Care Compass Hospitals. All rights reserved.</p>
    </footer>
</div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
