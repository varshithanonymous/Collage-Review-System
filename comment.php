<?php
session_start();
include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_email"])) {
    $email = $_SESSION["user_email"];
    $review_id = $_POST["review_id"];
    $comment = $_POST["comment"];
    $university = $_POST["university"];

    if (strpos($email, strtolower($university)) === false) {
        echo "<script>alert('You can only comment on your own university!'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO comments (review_id, email, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $review_id, $email, $comment);
    $stmt->execute();

    echo "<script>window.history.back();</script>";
}
?>
