<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $doctor = $_POST['doctor'];
    $diagnosis = $_POST['current-diagnosis'];
    
    $user_query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        
        $report_query = "INSERT INTO patient_reports (user_id, full_name, email, assigned_doctor, diagnosis) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($report_query);
        $stmt->bind_param("issss", $user_id, $name, $email, $doctor, $diagnosis);
        
        if ($stmt->execute()) {
            echo "Patient report recorded successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "User not found. Please register first.";
    }
    
    $stmt->close();
}
$conn->close();
?>
