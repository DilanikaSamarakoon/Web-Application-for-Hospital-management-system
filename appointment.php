<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $doctor_id = $_POST['doctor'];
    $branch = $_POST['branch'];
    $appointment_date = $_POST['date'];
    $appointment_time = $_POST['time'];
    $notes = $_POST['notes'];

    // Insert the data into the database
    $sql = "INSERT INTO appointments (name, email, phone, doctor_id, branch, appointment_date, appointment_time, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $name, $email, $phone, $doctor_id, $branch, $appointment_date, $appointment_time, $notes);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Appointment booked successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to book appointment. Please try again."]);
    }

    $stmt->close();
}

$conn->close();
?>
