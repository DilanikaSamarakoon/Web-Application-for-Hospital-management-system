<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is the admin
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        echo "Welcome, Admin!";
        // Redirect to admin dashboard
        header("Location: admin dash.html");
        exit;
    }

    // For other users, fetch from database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password for non-admin users
        if (password_verify($password, $user['password'])) {
            if ($user['role'] == 'admin') {
                echo "Welcome, Admin!";
                // Redirect to admin dashboard
                header("Location: admin dash.html");
                exit;
            } else {
                header("Location: patient dash.html");
                exit;
            }
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
    $conn->close();
}
?>
