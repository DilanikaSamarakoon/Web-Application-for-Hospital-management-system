<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$report = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $query = "SELECT full_name, assigned_doctor, diagnosis FROM patient_reports WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $report = $result->fetch_assoc();
    } else {
        $error = "No report found for this email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Report</title>
    <link rel="stylesheet" href="report-style.css">
   
</head>
<body>

<header>
    <h1>Care Compass Hospitals</h1>
</header>

<section>
    <h2>View Your Patient Report</h2>
    <form action="view_report.php" method="POST">
        <label for="email">Enter Your Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
        <button type="submit">View Report</button>
    </form>

    <?php if ($report): ?>
        <h3>Report Details</h3>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($report['full_name']); ?></p>
        <p><strong>Assigned Doctor:</strong> <?php echo htmlspecialchars($report['assigned_doctor']); ?></p>
        <p><strong>Diagnosis:</strong> <?php echo htmlspecialchars($report['diagnosis']); ?></p>
    <?php elseif (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
</section>

</body>
</html>
