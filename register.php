<?php
session_start();
include 'includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // ✅ Allowed university domains
    $allowed_domains = [
        'veltech.edu.in',
        'mallareddyuniversity.ac.in',
        'saveetha.ac.in',
        'srm.edu.in',
        'vit.edu.in'
    ];

    $domain = substr(strrchr($email, "@"), 1);
    if (!in_array($domain, $allowed_domains)) {
        echo "<div class='alert alert-danger text-center'>Please use your official university email address.</div>";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$check) {
            die("Prepare failed: " . $conn->error);
        }
        $check->bind_param("s", $email);
        $check->execute();
        $exists = $check->get_result();

        if ($exists->num_rows > 0) {
            echo "<div class='alert alert-warning text-center'>Email already registered!</div>";
        } else {
            $university_map = [
                'veltech.edu.in' => 'Veltech',
                'mallareddyuniversity.ac.in' => 'Malla Reddy',
                'saveetha.ac.in' => 'Saveetha',
                'srm.edu.in' => 'SRM',
                'vit.edu.in' => 'VIT'
            ];
        
            $_SESSION['university'] = $university_map[$domain] ?? 'Unknown';
            // Save data temporarily in session
            $_SESSION['reg_name'] = $name;
            $_SESSION['reg_email'] = $email;
            $_SESSION['reg_pass'] = $pass;

            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;

            // Send OTP
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'suort.project1@gmail.com'; // your Gmail
                $mail->Password = 'bhqi tulm srtc ocpu';     // use App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('suort.project1@gmail.com', 'Review System');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "OTP Verification";
                $mail->Body = "Your OTP code is <strong>$otp</strong>";

                $mail->send();
                header("Location: verify.php");
                exit();
            } catch (Exception $e) {
                echo "<div class='alert alert-danger text-center'>Mailer Error: " . $mail->ErrorInfo . "</div>";
            }
        }
    }
}
?>

<!-- Bootstrap Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h3 class="text-center mb-4">University Review System – Register</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input name="name" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">University Email</label>
                <input name="email" type="email" class="form-control" required>
                <div class="form-text">Use a valid university email (e.g., @veltech.edu.in)</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Create Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send OTP</button>
        </form>
        <div class="text-center mt-3">
            Already registered? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
