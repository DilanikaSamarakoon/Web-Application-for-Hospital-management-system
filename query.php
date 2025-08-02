<?php
session_start();
include('db_connect.php'); // Ensure DB connection file is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Only process when form is submitted

    // Ensure data is set before accessing
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, $_POST['message']) : '';

    // File upload handling
    $file_name = '';
    $file_path = '';

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = basename($_FILES['file']['name']);
        $file_path = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            die("File upload failed.");
        }
    }

    // Insert query
    $sql = "INSERT INTO Query (Name, Email, File, File_path, Message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $file_name, $file_path, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Query submitted successfully!'); window.location.href = 'contact.php';</script>";
        exit(); // Prevent further execution
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Compass Hospitals - Query</title>
    <link rel="stylesheet" href="query.css">
</head>

<body>
<!-- Query Form Section -->
<div class="query-container">
    <h1>Submit Your Query</h1>
   <form id="query-form" action="contact.php" method="POST" enctype="multipart/form-data">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>

    <label for="file">Upload Documents (Optional):</label>
    <input type="file" id="file" name="file">

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>

    <button type="submit">Submit</button>
</form>

</div>

        <p id="success-message" style="display: none; color: green; font-weight: bold; text-align: center; margin-top: 20px;">Your query has been submitted successfully!</p>
    </div>

   <script>
    document.getElementById('query-form').addEventListener('submit', function () {
        alert('Your query is being submitted...');
    });
</script>

</body>

</html>