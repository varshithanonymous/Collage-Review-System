<?php
session_start();
include "includes/db.php";  // ✅ Ensure this file exists and has correct connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    
    if (!$stmt) {
        die("Database Error (LOGIN): " . $conn->error);  // ✅ Debugging error if prepare() fails
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_email"] = $email;
            $_SESSION["user_name"] = $user["name"];
            echo "<script>alert('Login Successful!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Incorrect password!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with this email!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Login</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    
    <a href="register.php" class="btn btn-secondary mt-3 w-100">Register</a>
    <a href="dashboard.php" class="btn btn-outline-dark mt-3 w-100">Guest Login</a>  <!-- ✅ Guest Login Enabled -->
</div>
</body>
</html>
