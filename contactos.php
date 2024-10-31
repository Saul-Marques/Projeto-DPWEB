<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'db.php'; // Conexão à base de dados
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
</head>
<body>
    <body style="background-color: #EAEAEA;">
        <!-- Navbar -->
<nav class="navbar navbar-expand-sm" style="background-color: black;">
  <div class="container-fluid">
    <a class="navbar-brand align-self-center" href="index.php">
      <img src="imgs/logo.svg" style="width:69px;" alt="">
    </a>
    <div class="d-flex align-items-center">
      <!-- Icons são apresantados se o user estiver logado -->
      <?php if ($isLoggedIn == true): ?>
        <a class="btn" href="#">
          <img src="imgs/icons/iconperson.svg" alt="">
        </a>
        <a class="btn" href="#">
          <img src="imgs/icons/cart.svg" alt="">
        </a>
        <a class="btn" href="add_produto.html">
          <img src="imgs/icons/iconplus.svg" alt="">
        </a>
        <a class="btn" href="logout.php">
          <img src="imgs/icons/logout.svg" style="width:20px; height:20px;" alt="">
        </a>
      <!-- 'Login' e 'Registar' serão apresentados se o user nao estiver logado -->
      <?php else: ?>
        <a class="btn jomhuria-regular fs-2" style="color: white;" href="login.html">Login</a>
        <a class="btn jomhuria-regular fs-2" style="color: white;" href="registar.html">Registar</a>
      <?php endif; ?>

      <!-- Context menu -->
      <div class="dropstart ms-3">
        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: black;">
          <img src="imgs/icons/iconcont.svg" alt="">
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="contactos.html">Contactos</a></li>
          <li><a class="dropdown-item" href="faqs.html">FAQs</a></li>
          <li><a class="dropdown-item" href="#">Mais alguma cena aqui</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid">
<div class="row row-cols-1 row-cols-xxl-2 row-cols-lg-2 row-cols-sm-1 mt-5 ms-3">
  <div class="col jomhuria-regular fs-custom">
    Contactos:
    <br>
    <a href="" class="" style="text-decoration: none; color: black;">
      <img src="imgs/icons/mail.svg" style="height: 50px; width: 50px;" alt="">
    :cena&tal@email.com
    </a>
    
    <br>
    <a href="" style="text-decoration: none; color: black;">
      <img src="imgs/icons/telephone-fill.svg" style="height: 50px; width: 50px;" alt="">
    : 912345678
    </a>
    <br>
  </div>
  <div class="col jomhuria-regular fs-custom">
    Onde estamos: <br>
    <iframe class="rounded" style="border: 0;height: 500px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3046.9750171180885!2d-8.455043323295397!3d40.20961867147372!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22f8f0b85baeb7%3A0x190fc4c9387ddaaa!2sCoimbra%20Business%20School%20%7C%20ISCAC!5e0!3m2!1spt-PT!2spt!4v1730053466951!5m2!1spt-PT!2spt" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>
</div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>