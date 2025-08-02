<?php
session_start();
include('dbconnect.php');

// Check if the database connection is working
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Search</title>
</head>
<body>

    <h2>Search Hospital Services & Lab Facilities</h2>
    
    <form method="POST">
        <input type="text" name="query" placeholder="Enter service or lab facility..." required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php
    if (isset($_POST['search'])) {

        $query = trim($_POST['query']);

        // Debug: Check if input is received
        echo "Search Term: " . htmlspecialchars($query) . "<br>";

        $sql = $sql = "SELECT * FROM services WHERE name LIKE ?";

        
        // Debug: Check if SQL statement is prepared successfully
        if (!$stmt = $conn->prepare($sql)) {
            die("Query preparation failed: " . $conn->error);
        }

        $searchTerm = "%$query%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Search Results:</h3>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>" . $row['name'] . " (" . ucfirst($row['type']) . ")</strong><br>" . $row['description'] . "</p>";
            }
        } else {
            echo "<p>No results found.</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
