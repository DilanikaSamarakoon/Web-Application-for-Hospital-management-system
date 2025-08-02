<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed."]));
}

// Fetch the most recent payment entry
$sql = "SELECT full_name AS name, email, phone, branch, doctor_fee, additional_charges, total_amount 
        FROM payments ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "No payment record found."]);
}

$conn->close();
?>
