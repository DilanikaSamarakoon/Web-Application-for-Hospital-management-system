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
    $phone = $_POST['phone'];
    $branch = $_POST['branch'];
    $doctor_fee = $_POST['doctor'];
    $additional_charges = $_POST['additional-charges'];
    $total_amount = $doctor_fee + $additional_charges;
    
    $user_query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        
        $payment_query = "INSERT INTO payments (user_id, full_name, email, phone, branch, doctor_fee,additional_charges, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($payment_query);
        $stmt->bind_param("issssidd", $user_id, $name, $email, $phone, $branch, $doctor_fee, $additional_charges, $total_amount);
        
        if ($stmt->execute()) {
            echo "Payment recorded successfully!";
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
