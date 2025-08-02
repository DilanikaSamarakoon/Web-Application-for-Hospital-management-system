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
    $staff_id = $_POST['staff_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Capture doctor-specific fields if the role is Doctor
    $available_time = ($role == "Doctor") ? $_POST['available_time'] : NULL;
    $specialty = ($role == "Doctor") ? $_POST['specialty'] : NULL;

    $update_query = "UPDATE staff SET firstname = ?, lastname = ?, email = ?, phone = ?, role = ?, available_time = ?, specialty = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $phone, $role, $available_time, $specialty, $staff_id);

    if ($stmt->execute()) {
        echo "Staff updated successfully!";
        header('Location: view_staff.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $staff_id = $_GET['id'];
    $query = "SELECT * FROM staff WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="staff style.css">
</head>
<body>

<header>
    <h1>Edit Staff Details</h1>
</header>

<section>
    <form action="edit_staff.php" method="POST">
        <input type="hidden" name="staff_id" value="<?php echo $staff['id']; ?>">

        <label for="firstname">First Name</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($staff['firstname']); ?>" required>

        <label for="lastname">Last Name</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($staff['lastname']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" required>

        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($staff['phone']); ?>" required>

        <label for="role">Role</label>
        <select id="role" name="role" required onchange="toggleDoctorFields()">
            <option value="Manager" <?php if ($staff['role'] == 'Manager') echo 'selected'; ?>>Manager</option>
            <option value="Cashier" <?php if ($staff['role'] == 'Cashier') echo 'selected'; ?>>Cashier</option>
            <option value="Nurse" <?php if ($staff['role'] == 'Nurse') echo 'selected'; ?>>Nurse</option>
            <option value="Doctor" <?php if ($staff['role'] == 'Doctor') echo 'selected'; ?>>Doctor</option>
        </select>

        <!-- Doctor-Specific Fields (Hidden by Default) -->
        <div id="doctorFields" style="display: none;">
            <label for="available_time">Available Time</label>
            <input type="text" id="available_time" name="available_time" value="<?php echo htmlspecialchars($staff['available_time']); ?>">

            <label for="specialty">Specialty</label>
            <input type="text" id="specialty" name="specialty" value="<?php echo htmlspecialchars($staff['specialty']); ?>">
        </div>

        <button type="submit">Update Staff</button>
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

// Ensure doctor fields are visible if editing an existing doctor
window.onload = function() {
    if (document.getElementById("role").value === "Doctor") {
        document.getElementById("doctorFields").style.display = "block";
    }
};
</script>

</body>
</html>
