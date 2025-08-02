<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM patient_reports";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Reports</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="report style.css">
</head>
<body>

<header>
    <h1>Care Compass Hospitals - Patient Reports</h1>
</header>

<section>
    <h2>Patient Reports</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Assigned Doctor</th>
                <th>Diagnosis</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['assigned_doctor']; ?></td>
                <td><?php echo $row['diagnosis']; ?></td>
                <td>
                    <a href="edit_report.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                    <a href="delete_report.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this report?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

</body>
</html>

<?php
$conn->close();
?>
