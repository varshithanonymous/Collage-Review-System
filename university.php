<?php
session_start();
$university = isset($_GET["university"]) ? $_GET["university"] : "Unknown";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= htmlspecialchars($university) ?> - Options</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5 text-center">
    <h2><?= htmlspecialchars($university) ?> - Select Category</h2>
    <a href="reviews.php?university=<?= urlencode($university) ?>&category=college" class="btn btn-primary w-100 mb-2">College</a>
    <a href="reviews.php?university=<?= urlencode($university) ?>&category=hostel" class="btn btn-warning w-100 mb-2">Hostel</a>
    <a href="reviews.php?university=<?= urlencode($university) ?>&category=events" class="btn btn-success w-100 mb-2">Events</a>
    <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Back</a>
</div>
</body>
</html>
