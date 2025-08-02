<?php
// Display entered information if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $doctor = $_POST['doctor'];
    $diagnosis = $_POST['current-diagnosis'];

    // Display the entered details to the patient
    echo "<h1>Patient Report</h1>";
    echo "<h3>Entered Details:</h3>";
    echo "<p><strong>Full Name:</strong> " . htmlspecialchars($name) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Assigned Doctor:</strong> " . htmlspecialchars($doctor) . "</p>";
    echo "<p><strong>Current Diagnosis:</strong> " . nl2br(htmlspecialchars($diagnosis)) . "</p>";

    // Now, store this data into your database (if needed)
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "care_compass";

    // Create a new connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user exists in the database based on email
    $user_query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Fetch the user ID
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Insert the report into the database
        $report_query = "INSERT INTO patient_reports (user_id, full_name, email, assigned_doctor, diagnosis) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($report_query);
        $stmt->bind_param("issss", $user_id, $name, $email, $doctor, $diagnosis);

        if ($stmt->execute()) {
            echo "<p>Patient report recorded successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>User not found. Please register first.</p>";
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>

