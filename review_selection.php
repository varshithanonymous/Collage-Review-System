<?php
if (!isset($_GET["university"])) {
    die("Invalid request.");
}

$selected_university = $_GET["university"];

// Define the first image for each university
$university_images = [
    "Veltech" => "vel1.jpg",
    "Malla Reddy" => "mal1.png",
    "Saveetha" => "sav1.png",
    "SRM" => "srm1.png",
    "VIT" => "vit1.png"
];

$image_path = isset($university_images[$selected_university]) ? "images/" . $university_images[$selected_university] : "images/default.jpg";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= htmlspecialchars($selected_university) ?> - Select Category</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .full-image {
            width: 100%;
            height: auto;
            max-height: 500px; /* Adjust based on your preference */
            object-fit: contain; /* Ensures the full image is visible */
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container mt-5 text-center">
    <h2>Welcome to <?= htmlspecialchars($selected_university) ?></h2>

    <!-- Display Full University Image -->
    <img src="<?= $image_path ?>" alt="<?= htmlspecialchars($selected_university) ?>" class="full-image mb-4">

    <h4>Select Category</h4>
    <div class="d-flex justify-content-center mt-3">
        <a href="reviews.php?university=<?= urlencode($selected_university) ?>&category=college" class="btn btn-primary mx-2">College</a>
        <a href="reviews.php?university=<?= urlencode($selected_university) ?>&category=hostel" class="btn btn-success mx-2">Hostel</a>
        <a href="reviews.php?university=<?= urlencode($selected_university) ?>&category=events" class="btn btn-warning mx-2">Events</a>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>
</div>

</body>
</html>
