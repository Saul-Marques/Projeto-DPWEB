<?php 
session_start();
include '../includes/db.php';
$isLoggedIn = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ups...</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="../imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/fonts/customfonts.css">
</head>
<body style="background-color: #EAEAEA;">
    <nav class="navbar navbar-expand-sm" style="background-color: black;">
        <div class="container-fluid">
            <a class="navbar-brand align-self-center" href="../index.php">
                <img src="../imgs/logo.svg" style="width:69px;" alt="">
            </a>
            <div class="d-flex align-items-center">
            <!-- Icons são apresantados se o user estiver logado -->
            <?php if ($isLoggedIn == true): ?>
                <a class="btn" href="../pagina_utilizador.php">
                <img src="../imgs/icons/iconperson.svg" alt="">
                </a>
                <a class="btn" href="#">
                <img src="../imgs/icons/cart.svg" alt="">
                </a>
                <a class="btn" href="../add_produto.php">
                <img src="../imgs/icons/iconplus.svg" alt="">
                </a>
                <a class="btn" href="logout.php">
                <img src="../imgs/icons/logout.svg" style="width:20px; height:20px;" alt="">
                </a>
            <!-- 'Login' e 'Registar' serão apresentados se o user nao estiver logado -->
            <?php else: ?>
                <a class="btn jomhuria-regular fs-2" style="color: white;" href="../login.html">Login</a>
                <a class="btn jomhuria-regular fs-2" style="color: white;" href="../registar.html">Registar</a>
            <?php endif; ?>

            <!-- Context menu -->
                <div class="dropstart ms-3">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: black;">
                    <img src="../imgs/icons/iconcont.svg" alt="">
                    </button>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../contactos.php">Contactos</a></li>
                    <li><a class="dropdown-item" href="../faqs.php">FAQs</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container d-flex align-items-center justify-content-center" style="margin-top: 200px">
        <div class="row align-items-center text-center text-lg-start">
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <img src="../imgs/Frame 3.svg" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>

            <div class="col-12 col-lg-6">
                <h1 class="jomhuria-regular fs-custom" style="color: black">Uh, Ohh...</h1>
                <p class="fs-custom jomhuria-regular">Parece que a password ou o login está errado...</p>
                <a href="../login.html" class="btn rounded-4 border-0 jomhuria-regular fs-1 mt-5" style="background-color: #000000; color: white; line-height:1">
                    Voltar atrás.
                </a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>