<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all staff members
$query = "SELECT * FROM staff ORDER BY role ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
    <link rel="stylesheet" href="show staff.css">
    
</head>
<body>

<header>
    <h1>Staff List</h1>
</header>

<section>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Available Time</th>
            <th>Specialty</th>
            
        </tr>

        <?php while ($staff = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $staff['id']; ?></td>
            <td><?php echo htmlspecialchars($staff['firstname']); ?></td>
            <td><?php echo htmlspecialchars($staff['lastname']); ?></td>
            <td><?php echo htmlspecialchars($staff['email']); ?></td>
            <td><?php echo htmlspecialchars($staff['phone']); ?></td>
            <td><?php echo htmlspecialchars($staff['role']); ?></td>

            <!-- Show Doctor-Specific Details Only for Doctors -->
            <td><?php echo ($staff['role'] == "Doctor") ? htmlspecialchars($staff['available_time']) : "N/A"; ?></td>
            <td><?php echo ($staff['role'] == "Doctor") ? htmlspecialchars($staff['specialty']) : "N/A"; ?></td>

           
        </tr>
        <?php } ?>
    </table>
</section>

</body>
</html>

<?php
$conn->close();
?>
