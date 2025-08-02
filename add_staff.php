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
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Capture doctor-specific fields if the role is Doctor
    $available_time = ($role == "Doctor") ? $_POST['available_time'] : NULL;
    $specialty = ($role == "Doctor") ? $_POST['specialty'] : NULL;

    // Prepare the SQL query
    $query = "INSERT INTO staff (firstname, lastname, email, phone, role, available_time, specialty) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $firstname, $lastname, $email, $phone, $role, $available_time, $specialty);

    if ($stmt->execute()) {
        echo "Staff added successfully!";
        header('Location: view_staff.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Add Staff</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="staff style.css">
</head>
<body>

<header>
    <h1>Add New Staff</h1>
</header>

<section>
    <form action="add_staff.php" method="POST">
        <label for="firstname">First Name</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="role">Role</label>
        <select id="role" name="role" required onchange="toggleDoctorFields()">
            <option value="Manager">Manager</option>
            <option value="Cashier">Cashier</option>
            <option value="Nurse">Nurse</option>
            <option value="Doctor">Doctor</option>
        </select>

        <!-- Doctor-Specific Fields (Hidden by Default) -->
        <div id="doctorFields" style="display: none;">
            <label for="available_time">Available Time</label>
            <input type="text" id="available_time" name="available_time">

            <label for="specialty">Specialty</label>
            <input type="text" id="specialty" name="specialty">
        </div>

        <button type="submit">Add Staff</button>
    </form>
</section>

<script>
function toggleDoctorFields() {
    let role = document.getElementById("role").value;
    let doctorFields = document.getElementById("doctorFields");

    if (role === "Doctor") {
        doctorFields.style.display = "block";
    } else {
        doctorFields.style.display = "none";
    }
}
</script>

</body>
</html>

