<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM payments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Payments</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <header>
        <h1>Payment Management</h1>
    </header>

    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Branch</th>
            <th>Doctor Fee</th>
           
            <th>Additional Charges</th>
            <th>Total Amount</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['branch']; ?></td>
            <td><?php echo $row['doctor_fee']; ?></td>
            
            <td><?php echo $row['additional_charges']; ?></td>
            <td><?php echo $row['total_amount']; ?></td>
            <td>
                <a href="edit_payment.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_payment.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
