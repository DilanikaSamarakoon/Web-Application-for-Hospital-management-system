<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $feedback_id = $_GET['id'];

    $delete_query = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        echo "Feedback deleted successfully!";
        header('Location: view_feedback.php');
    } else {
        echo "Error deleting feedback: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
