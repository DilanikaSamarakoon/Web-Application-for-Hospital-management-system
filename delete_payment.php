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
    $id = $_GET['id'];
    $sql = "DELETE FROM payments WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Payment deleted successfully'); window.location='admin_payments.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
