<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION["user_email"] = $email;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2 class="text-center">University Review System</h2>

    <form method="post" class="card p-4 mt-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
        <label>Password:</label>
        <input type="password" name="password" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-2">Login</button>
    </form>

    <p class="mt-3 text-center">
        <a href="register.php" class="btn btn-success">Register</a>
        <a href="dashboard.php" class="btn btn-secondary">Continue as Guest</a>
    </p>
</body>
</html>
