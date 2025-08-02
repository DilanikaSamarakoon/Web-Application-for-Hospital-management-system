<?php
// Database connection
$servername = "localhost"; // Change to your server
$username = "root"; // Change to your DB username
$password = ""; // Change to your DB password
$dbname = "care_compass"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$email = $_POST['email'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validation
if ($new_password != $confirm_password) {
    echo "New passwords do not match.";
    exit();
}

// Fetch the user by email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "No user found with that email.";
    exit();
}

// Verify old password
if (!password_verify($old_password, $user['password'])) {
    echo "Old password is incorrect.";
    exit();
}

// Hash the new password
$hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

// Update the user's password
$sql = "UPDATE users SET password = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $hashed_new_password, $email);
if ($stmt->execute()) {
    echo "Password changed successfully!";
} else {
    echo "Error changing password: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
