<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "care_compass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM payments WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $branch = $_POST['branch'];
    $doctor_fee = $_POST['doctor_fee'];
   
    $additional_charges = $_POST['additional_charges'];
    $total_amount = $doctor_fee + $additional_charges;

    $update_sql = "UPDATE payments SET 
        full_name = '$full_name', 
        email = '$email', 
        phone = '$phone', 
        branch = '$branch', 
        doctor_fee = $doctor_fee, 
         
        additional_charges = $additional_charges, 
        total_amount = $total_amount
        WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Payment updated successfully'); window.location='admin_payments.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="pay sheet.css">
</head>
<body>
    <h2>Edit Payment</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo $row['phone']; ?>" required>
        <label>Branch:</label>
        <input type="text" name="branch" value="<?php echo $row['branch']; ?>" required>
        <label>Doctor Fee:</label>
        <input type="number" name="doctor_fee" value="<?php echo $row['doctor_fee']; ?>" required>
        
        <label>Additional Charges:</label>
        <input type="number" name="additional_charges" value="<?php echo $row['additional_charges']; ?>" required>
        <button type="submit">Update Payment</button>
    </form>
</body>
</html>
