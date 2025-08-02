<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM feedback";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="feedback style.css">
</head>
<body>

<header>
    <h1>Feedback Management</h1>
</header>

<section>
    <h2>All Feedback</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Feedback</th>
                
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo substr($row['feedback'], 0, 50) . '...'; ?></td>
                
                <td>
                    <a href="delete_feedback.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</a>
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
