<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['email'])) {
    echo "You must be logged in to reply!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id']) && isset($_POST['comment'])) {
    $review_id = $_POST['review_id'];
    $comment = trim($_POST['comment']);
    $user_email = $_SESSION['email'];

    // Get user's university
    $stmt = $conn->prepare("SELECT university FROM users WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();
    $user_university = $user['university'];

    // Get review's university
    $stmt = $conn->prepare("SELECT university FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $reviewResult = $stmt->get_result();
    $review = $reviewResult->fetch_assoc();

    if (!$review) {
        echo "Review not found!";
        exit();
    }

    // Check if the user belongs to the same university
    if ($user_university !== $review['university']) {
        echo "You can only reply to reviews from your university!";
        exit();
    }

    // Insert reply into the database
    $stmt = $conn->prepare("INSERT INTO comments (review_id, email, comment, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $review_id, $user_email, $comment);
    
    if ($stmt->execute()) {
        echo "Reply added successfully!";
    } else {
        echo "Error adding reply!";
    }
} else {
    echo "Invalid request!";
}
?>
