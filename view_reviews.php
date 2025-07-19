<?php
// Fetch reviews (example query)
$reviews = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");

while ($review = $reviews->fetch_assoc()):
?>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong><?= htmlspecialchars($review['email']) ?>:</strong> <?= nl2br(htmlspecialchars($review['review'])) ?></p>
            <p class="text-muted small">Posted on <?= $review['created_at'] ?> (<?= $review['university'] ?>)</p>

            <!-- Only allow reply if same university -->
            <?php if (isset($_SESSION['university']) && $_SESSION['university'] === $review['university']): ?>
                <form method="POST" action="add_comment.php">
                    <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                    <textarea name="comment" class="form-control mb-2" required placeholder="Reply..."></textarea>
                    <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Comments section -->
        <?php
        $rid = $review['id'];
        $comments = $conn->query("SELECT * FROM comments WHERE review_id = $rid ORDER BY created_at ASC");
        while ($cmt = $comments->fetch_assoc()):
        ?>
            <div class="ps-4 pt-2 pb-2 border-top">
                <p class="mb-1"><strong><?= htmlspecialchars($cmt['email']) ?>:</strong> <?= nl2br(htmlspecialchars($cmt['comment'])) ?></p>
                <p class="text-muted small">Commented on <?= $cmt['created_at'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
<?php endwhile; ?>
