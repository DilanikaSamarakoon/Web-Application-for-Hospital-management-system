<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM staff";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="staff style.css">
</head>
<body>

<header>
    <h1>Staff Management</h1>
</header>

<section>
    <h2>Staff List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <a href="edit_staff.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                    <a href="delete_staff.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</a>
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
