<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['otp']) || !isset($_SESSION['reg_email'])) {
    echo "<script>alert('Unauthorized access.'); window.location='register.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];

    if ($enteredOtp == $_SESSION['otp']) {
        // Proceed with registration
        $name = $_SESSION['reg_name'];
        $email = $_SESSION['reg_email'];
        $password = $_SESSION['reg_pass'];

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            unset($_SESSION['otp'], $_SESSION['reg_name'], $_SESSION['reg_email'], $_SESSION['reg_pass']);
            echo "<script>alert('Registration successful! You can now log in.'); window.location='login.php';</script>";
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error saving user.</div>";
        }
    } else {
        echo "<script>alert('Invalid OTP!');</script>";
    }
}
?>

<!-- Bootstrap OTP Verification Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 400px;">
        <h4 class="text-center mb-3">Email OTP Verification</h4>
        <form method="POST">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter OTP sent to your email</label>
                <input type="number" class="form-control" id="otp" name="otp" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Verify OTP</button>
        </form>
    </div>
</body>
</html>
