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
    $report_id = $_POST['report_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $doctor = $_POST['doctor'];
    $diagnosis = $_POST['current-diagnosis'];

    $update_query = "UPDATE patient_reports SET full_name = ?, email = ?, assigned_doctor = ?, diagnosis = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssi", $name, $email, $doctor, $diagnosis, $report_id);

    if ($stmt->execute()) {
        echo "Report updated successfully!";
        header('Location: view_reports.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $report_id = $_GET['id'];
    $query = "SELECT * FROM patient_reports WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Report</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="report style.css">
</head>
<body>

<header>
    <h1>Edit Patient Report</h1>
</header>

<section>
    <h2>Edit Report for <?php echo $report['full_name']; ?></h2>
    <form action="edit_report.php" method="POST">
        <input type="hidden" name="report_id" value="<?php echo $report['id']; ?>">

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="<?php echo $report['full_name']; ?>" required>

        <label for="email">Email (Optional)</label>
        <input type="email" id="email" name="email" value="<?php echo $report['email']; ?>">

        <label for="doctor">Assigned Doctor</label>
        <select id="doctor" name="doctor" required>
            <option value="Dr. John Doe" <?php if ($report['assigned_doctor'] == 'Dr. John Doe') echo 'selected'; ?>>Dr. John Doe (Cardiologist)</option>
            <option value="Dr. Jane Smith" <?php if ($report['assigned_doctor'] == 'Dr. Jane Smith') echo 'selected'; ?>>Dr. Jane Smith (Dermatologist)</option>
            <option value="Dr. Mark Taylor" <?php if ($report['assigned_doctor'] == 'Dr. Mark Taylor') echo 'selected'; ?>>Dr. Mark Taylor (Pediatrician)</option>
        </select>

        <label for="current-diagnosis">Current Diagnosis</label>
        <textarea id="current-diagnosis" name="current-diagnosis" rows="3" required><?php echo $report['diagnosis']; ?></textarea>

        <button type="submit">Update Report</button>
    </form>
</section>

</body>
</html>

<?php
$conn->close();
?>
