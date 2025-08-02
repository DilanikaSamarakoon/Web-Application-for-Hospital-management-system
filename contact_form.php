<?php
// Include database connection
include'db_connect.php'; // Replace with the correct path to your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "All fields are required!";
        exit;
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameters to the query
        $stmt->bind_param("ssss", $name, $email, $phone, $message);

        // Execute the query
        if ($stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
