<?php
session_start();
include 'includes/db.php';

// Check if university and category are set
if (!isset($_GET['university']) || !isset($_GET['category'])) {
    echo "Invalid university or category!";
    exit();
}

$university = $_GET['university'];
$category = $_GET['category'];

// Fetch reviews for the selected university and category
$stmt = $conn->prepare("SELECT * FROM reviews WHERE university = ? AND category = ? ORDER BY created_at DESC");
$stmt->bind_param("ss", $university, $category);
$stmt->execute();
$result = $stmt->get_result();

// Get the logged-in user's university (if logged in)
$user_university = null;
if (isset($_SESSION['email'])) {
    $stmt = $conn->prepare("SELECT university FROM users WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $user = $userResult->fetch_assoc();
    $user_university = $user['university'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - <?php echo htmlspecialchars($university); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container { margin-top: 30px; }
        .suggestions { margin-bottom: 10px; }
        .suggestion-btn { margin: 5px; }
        .review-box { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center"><?php echo htmlspecialchars($university) . " - " . htmlspecialchars($category); ?> Reviews</h2>
        
        <!-- Add Review Form -->
        <div class="card p-3 mb-3">
            <h5>Add a Review</h5>
            <div class="suggestions">
                <button class="btn btn-outline-secondary suggestion-btn">Amazing Experience!</button>
                <button class="btn btn-outline-secondary suggestion-btn">Good Infrastructure</button>
                <button class="btn btn-outline-secondary suggestion-btn">Faculty needs improvement</button>
                <button class="btn btn-outline-secondary suggestion-btn">Hostel food is bad</button>
            </div>
            <form id="reviewForm">
                <textarea id="reviewText" class="form-control" placeholder="Write your review..."></textarea>
                <button type="button" id="submitReview" class="btn btn-success mt-2">Submit</button>
            </form>
        </div>

        <!-- Display Reviews -->
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review-box">
                <p><strong><?php echo htmlspecialchars($row['email']); ?></strong> said:</p>
                <p><?php echo htmlspecialchars($row['review']); ?></p>
                <small class="text-muted"><?php echo $row['created_at']; ?></small>

                <!-- Reply Section (Only for same university students) -->
                <?php if (isset($_SESSION['email']) && $user_university === $row['university']): ?>
                    <button class="btn btn-primary btn-sm reply-btn mt-2" data-review-id="<?php echo $row['id']; ?>">Reply</button>
                    <div class="reply-form mt-2" id="replyForm-<?php echo $row['id']; ?>" style="display: none;">
                        <textarea class="form-control reply-text"></textarea>
                        <button class="btn btn-success btn-sm mt-1 submit-reply" data-review-id="<?php echo $row['id']; ?>">Post Reply</button>
                    </div>
                <?php endif; ?>

                <!-- Show Comments -->
                <div class="mt-3">
                    <strong>Replies:</strong>
                    <div id="comments-<?php echo $row['id']; ?>">
                        <?php
                        $stmt2 = $conn->prepare("SELECT * FROM comments WHERE review_id = ? ORDER BY created_at ASC");
                        $stmt2->bind_param("i", $row['id']);
                        $stmt2->execute();
                        $commentsResult = $stmt2->get_result();
                        while ($comment = $commentsResult->fetch_assoc()) {
                            echo "<p><strong>" . htmlspecialchars($comment['email']) . ":</strong> " . htmlspecialchars($comment['comment']) . "</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script>
        $(document).ready(function () {
            // Suggestion buttons
            $(".suggestion-btn").click(function () {
                $("#reviewText").val($(this).text());
            });

            // Submit Review
            $("#submitReview").click(function () {
                var reviewText = $("#reviewText").val().trim();
                if (reviewText === "") {
                    alert("Please enter a review!");
                    return;
                }

                $.post("add_review.php", {
                    university: "<?php echo $university; ?>",
                    category: "<?php echo $category; ?>",
                    review: reviewText
                }, function (response) {
                    alert(response);
                    location.reload();
                });
            });

            // Show Reply Form
            $(".reply-btn").click(function () {
                var reviewId = $(this).data("review-id");
                $("#replyForm-" + reviewId).toggle();
            });

            // Submit Reply
            $(".submit-reply").click(function () {
                var reviewId = $(this).data("review-id");
                var commentText = $("#replyForm-" + reviewId + " .reply-text").val().trim();

                if (commentText === "") {
                    alert("Please enter a reply!");
                    return;
                }

                $.post("reply.php", {
                    review_id: reviewId,
                    comment: commentText
                }, function (response) {
                    alert(response);
                    location.reload();
                });
            });
        });
    </script>
</body>
</html>
