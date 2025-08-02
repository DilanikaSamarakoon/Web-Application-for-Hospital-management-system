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

// Handle feedback deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_feedback'])) {
    $feedback_id = $conn->real_escape_string($_POST['feedback_id']);
    $delete_sql = "DELETE FROM feedback WHERE id='$feedback_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Feedback deleted successfully!";
    } else {
        echo "Error deleting feedback: " . $conn->error;
    }
}

// Fetch feedback from the database
$sql = "SELECT * FROM feedback ORDER BY id DESC";
$result = $conn->query($sql);
?>

<?php
// Close the connection
$conn->close();
?>