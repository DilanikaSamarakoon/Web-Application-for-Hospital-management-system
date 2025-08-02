<?php
// Database connection details
$host = 'localhost';
$dbname = 'care_compass';
$username = 'root'; // Replace with your MySQL username
$password = '';     // Replace with your MySQL password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $doctor_id = $_POST['doctor'];
    $branch = $_POST['branch'];
    $appointment_date = $_POST['date'];
    $appointment_time = $_POST['time'];
    $notes = $_POST['notes'];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO appointments (name, email, phone, doctor_id, branch, appointment_date, appointment_time, notes)
            VALUES (:name, :email, :phone, :doctor_id, :branch, :appointment_date, :appointment_time, :notes)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':branch', $branch);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':appointment_time', $appointment_time);
    $stmt->bindParam(':notes', $notes);

    if ($stmt->execute()) {
        echo "Appointment successfully booked!";
    } else {
        echo "Failed to book appointment. Please try again.";
    }
}
?>
