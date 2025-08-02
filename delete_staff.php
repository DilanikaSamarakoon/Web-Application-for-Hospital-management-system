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
    $staff_id = $_GET['id'];

    $delete_query = "DELETE FROM staff WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $staff_id);

    if ($stmt->execute()) {
        echo "Staff deleted successfully!";
        header('Location: view_staff.php');
    } else {
        echo "Error deleting staff: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
