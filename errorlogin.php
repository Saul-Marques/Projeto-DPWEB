<?php 
session_start();
include 'includes/db.php';
$isLoggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ups...</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="../imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
</head>
<body style="background-color: #EAEAEA;">
    <?php include 'includes/navbar.php' ?>

    <div class="container d-flex align-items-center justify-content-center" style="margin-top: 200px">
        <div class="row align-items-center text-center text-lg-start">
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <img src="imgs/Frame 3.svg" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>

            <div class="col-12 col-lg-6">
                <h1 class="jomhuria-regular fs-custom" style="color: black">Uh, Ohh...</h1>
                <p class="fs-custom jomhuria-regular">Parece que a password ou o login está errado...</p>
                <a href="login.html" class="btn rounded-4 border-0 jomhuria-regular fs-1 mt-5" style="background-color: #000000; color: white; line-height:1">
                    Voltar atrás.
                </a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>