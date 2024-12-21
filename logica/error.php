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
                    <li><a class="dropdown-item" href="#">Mais alguma cena aqui</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="coltainer-fluid">
        
        <p class="fs-custom jomhuria-regular ms-5 mt-5">Uh, Oh...</p>
        <p class="fs-custom jomhuria-regular ms-5">Parece que algo correu mal...</p>
        <div class="d-flex" style="justify-content:center">
            <img src="../imgs/icons/cowboy.png" class="ms-5 mb-5" alt="">
        </div>
            
        
    </div>

    <footer style="background-color: black; color: white;">
        <div class="container">
            <div class="row row-cols-2">
                <!--Coluna da esquerda-->
                <div class="col">
                <img src="../imgs/logo.svg" class="mt-5 mb-5" alt="">
                </div>
                <div class="col">
                <p class="mt-3" style="color: #c4c4c4;"> Informações</p>
                <a class="btn" style="color: #ffffff;" href="../faqs.html"> FAQs</a>
                <br>
                <a class="btn" style="color: #ffffff;" href="../contactos.php"> Contactos</a>
                <br>
                <br>
                <p> Desenvolvido por: Saúl Marques & Vicente Rosa</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>