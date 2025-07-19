<?php
session_start();
$university = isset($_GET['university']) ? $_GET['university'] : "Unknown";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>College - <?php echo ucfirst($university); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand"><?php echo ucfirst($university); ?> - College</a>
        <a href="university.php?name=<?php echo $university; ?>" class="btn btn-light">Back</a>
    </div>
</nav>

<div class="container mt-5 text-center">
    <h2>Explore College</h2>

    <div class="row mt-4">
        <div class="col-md-4">
            <a href="reviews.php?university=<?php echo $university; ?>&category=classrooms" class="btn btn-primary w-100 p-3">Classrooms</a>
        </div>
        <div class="col-md-4">
            <a href="reviews.php?university=<?php echo $university; ?>&category=faculty" class="btn btn-success w-100 p-3">Faculty</a>
        </div>
        <div class="col-md-4">
            <a href="reviews.php?university=<?php echo $university; ?>&category=labs" class="btn btn-warning w-100 p-3">Labs</a>
        </div>
    </div>
</div>
<a href="university.php?university=<?= $_SESSION['university'] ?>" class="btn btn-secondary">Back</a>


</body>
</html>
