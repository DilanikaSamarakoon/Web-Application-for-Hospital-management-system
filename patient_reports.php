<?php
session_start();
require 'db_connect.php'; // Ensure you have a secure database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch patient reports for the logged-in user
$stmt = $conn->prepare("SELECT full_name, email, assigned_doctor, diagnosis FROM patient_reports WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$reports = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Reports</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Care Compass Hospitals</h1>
</header>

<section>
    <h2>Your Medical Reports</h2>
    <table border="1">
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Assigned Doctor</th>
            <th>Diagnosis</th>
        </tr>
        <?php if (!empty($reports)) { 
            foreach ($reports as $report) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($report['email']); ?></td>
                    <td><?php echo htmlspecialchars($report['assigned_doctor']); ?></td>
                    <td><?php echo htmlspecialchars($report['diagnosis']); ?></td>
                </tr>
        <?php } 
        } else { ?>
            <tr><td colspan="4">No reports available.</td></tr>
        <?php } ?>
    </table>
</section>

</body>
</html>
