<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];
    $comment = $_POST['comment'];
    $email = $_SESSION['email'] ?? '';
    $user_uni = $_SESSION['university'] ?? '';

    if (!$email || !$user_uni) {
        echo "<div class='alert alert-danger text-center'>Unauthorized access.</div>";
        exit;
    }

    // Fetch university of the review
    $stmt = $conn->prepare("SELECT university FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res && $res['university'] === $user_uni) {
        $stmt = $conn->prepare("INSERT INTO comments (review_id, email, comment, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $review_id, $email, $comment);
        $stmt->execute();
        header("Location: view_reviews.php");
    } else {
        echo "<div class='alert alert-danger text-center'>You can only reply to reviews from your own university.</div>";
    }
}
?>
