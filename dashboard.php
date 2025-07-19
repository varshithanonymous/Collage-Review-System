<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>University Reviews</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .carousel-item img {
            width: 100%;
            height: 200px; /* ✅ Smaller card-sized images */
            object-fit: cover;
            border-radius: 10px;
        }
        .carousel-container {
            max-width: 900px; /* ✅ Keeps it compact */
            margin: auto;
        }
        .card {
            cursor: pointer;
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Select Your University</h2>

    <div class="row justify-content-center">
        <?php
        $universities = [
            "Veltech" => ["vel1.jpg", "vel2.jpg", "vel3.jpg"],
            "Malla Reddy" => ["mal1.png", "mal2.jpg", "mal3.jpg"],
            "Saveetha" => ["sav1.png", "sav2.jpg", "sav3.jpg"],
            "VIT" => ["vit1.png", "vit2.jpg", "vit3.jpg"],
            "SRM" => ["srm1.png", "srm2.jpg", "srm3.jpg"]
        ];

        foreach ($universities as $name => $images) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card p-3 shadow" onclick="window.location.href=\'review_selection.php?university=' . urlencode($name) . '\'">
                    <h5 class="text-center">' . $name . '</h5>
                    <div id="carousel' . str_replace(' ', '', $name) . '" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">';

            foreach ($images as $index => $img) {
                echo '<div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">
                        <img src="images/' . $img . '" class="d-block w-100">
                      </div>';
            }

            echo '      </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel' . str_replace(' ', '', $name) . '" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel' . str_replace(' ', '', $name) . '" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
