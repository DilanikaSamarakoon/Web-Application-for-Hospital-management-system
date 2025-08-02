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
    $report_id = $_GET['id'];

    $delete_query = "DELETE FROM patient_reports WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $report_id);

    if ($stmt->execute()) {
        echo "Report deleted successfully!";
        header('Location: view_reports.php');
    } else {
        echo "Error deleting report: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
