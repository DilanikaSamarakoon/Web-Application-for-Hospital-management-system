<?php
@include 'care_compass';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $branch = mysqli_real_escape_string($conn, $_POST['branch']);
    $doctor_fee = mysqli_real_escape_string($conn, $_POST['doctor']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['date']);
    $additional_charges = mysqli_real_escape_string($conn, $_POST['additional-charges']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total-amount']);

    // Insert the payment data into the database
    $sql = "INSERT INTO payments (name, email, phone, branch, doctor, appointment_date, additional_charges, total_amount) 
            VALUES ('$name', '$email', '$phone', '$branch', '$doctor_fee', '$appointment_date', '$additional_charges', '$total_amount')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Payment successful!'); window.location.href='payment_success.html';</script>";
    } else {
        echo "<script>alert('Error processing payment: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}
?>
