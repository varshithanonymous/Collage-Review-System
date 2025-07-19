<?php
session_start();
$university = isset($_GET['university']) ? $_GET['university'] : "Unknown";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hostel - <?php echo ucfirst($university); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand"><?php echo ucfirst($university); ?> - Hostel</a>
        <a href="university.php?name=<?php echo $university; ?>" class="btn btn-light">Back</a>
    </div>
</nav>

<div class="container mt-5 text-center">
    <h2>Explore Hostel</h2>

    <div class="row mt-4">
        <div class="col-md-4">
            <a href="reviews.php?university=<?php echo $university; ?>&category=rooms" class="btn btn-primary w-100 p-3">Rooms</a>
        </div>
        <div class="col-md-4">
            <a href="reviews.php?university=<?php echo $university; ?>&category=food" class="btn btn-success w-100 p-3">Food</a>
        </div>
        <div class="col-md-4">
            <a href="reviews.php?university=<?php echo $university; ?>&category=warden" class="btn btn-warning w-100 p-3">Warden</a>
        </div>
    </div>
    <a href="university.php?university=<?= $_SESSION['university'] ?>" class="btn btn-secondary">Back</a>

</div>

</body>
</html>
