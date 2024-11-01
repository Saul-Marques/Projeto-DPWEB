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
    <title>Produto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
</head>
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

  <div class="row ms-5 mt-5 me-5">
    <!--Coluna sem nada-->
    <div class="col-1">

    </div>
    <!--Coluna das imagens e da descricao-->
    <div class="col-7 " >
      <div class="row rounded" style="background-color: #D9D9D9; height: 517px;">
        Imagens
      </div>
      <!--Descrição-->
      <div class="row rounded mt-3" style="background-color: white; height: 514px;">
        <div class="col-11">
          <p class="jomhuria-regular fs-custom ms-3 mb-0 g-0">
            Título
          </p>
          <p class="jomhuria-regular ms-3 fs-1 mt-0" style="color: #D9D9D9;">
            Descrição:
          </p>
        </div>
        <div class="col mt-4">
          <img src="imgs/icons/bookmark.svg" style="width: 28px; height: 28px;" alt="">
        </div>
        
      </div>
    </div>
    <!--Coluna das licitacoes e utilizador-->
    <div class="col-3 ms-3">
      <div class="row rounded" style="background-color: white;">
        <div class="col">
          <p class="jomhuria-regular fs-4 g-0 mb-0 mt-2" style="line-height: 1; color: #2C2C2C;">
            Publicado a:
          </p>
          <p class="jomhuria-regular fs-custom" style="line-height: 1;">
            Titulo
          </p>
          <p class="jomhuria-regular fs-1">
            Preço:
          </p>
          <p class="jomhuria-regular fs-1" style="line-height: 1;">
            Licitação atual:
          </p>
          <p class="jomhuria-regular fs-4 g-0 mb-0 mt-2" style="line-height: 0; color: #5E5E5E;">
            Termina em:
          </p>
          <br>
          <div class="input-group">
            <input type="text" class="form-control rounded-4 border-1 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #BBBBBB; line-height: 0; border-color: black;" placeholder="Valor a licitar" name="licitacao" required>
          </div>
          <div class="btn rounded-4 border-1 jomhuria-regular fs-1 align-self-center me-5 mt-3" style="background-color: #BBBBBB; border-color: black; width: 100%; line-height: 1;">
            Licitar
          </div>

          <div class="btn rounded-4 border-0 jomhuria-regular fs-1 align-self-center me-5 mb-3 mt-3" style="background-color: #000000; width: 100%; line-height: 1; color: white;">
            Comprar agora.
          </div>
        </div>
        
      </div>
      <div class="row rounded mt-3" style="background-color: white; height: 347px;">
        <div class="col">
          <p class="jomhuria-regular fs-1" style="line-height: 1; color: #5E5E5E;">
            Utilizador:
          </p>
          <p class="jomhuria-regular fs-custom" style="line-height: 1; color: #000000;">
            <img src="imgs/icons/account_circle.svg" alt="">
            (Nome de utilizador)
          </p>
          <p class="jomhuria-regular fs-1" style="line-height: 1; color: #000000;">
            Ultimas licitações:
          </p>
          <pre class="jomhuria-regular fs-3" style="line-height: 1; color: #5E5E5E;">(nome de utilizador) Há 00h                                10.00€</pre>
        </div>
        
      </div>
    </div>
  </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>