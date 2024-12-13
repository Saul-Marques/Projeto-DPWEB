<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'includes/db.php'; // Conexão à base de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get form data
  $nome = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $mensagem = trim($_POST['mensagem']);

  // Validate form inputs
  if (!empty($nome) && !empty($email) && !empty($mensagem)) {
      try {
          // Prepare SQL query
          $stmt = $conn->prepare("INSERT INTO feedback (nome, email, mensagem, enviado_a) VALUES (?, ?, ?, NOW())");
          $stmt->bind_param("sss", $nome, $email, $mensagem);
          $stmt->execute(); // Execute query
          $stmt->close();
      } catch (Exception $e) {
          echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
      }
  } else {
      echo "<div class='alert alert-danger'>Preencha todos os campos obrigatórios.</div>";
  }
}
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
    <link href='https://fonts.googleapis.com/css?family=Jost' rel='stylesheet'>
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
        <a class="btn" href="pagina_utilizador.php">
          <img src="imgs/icons/iconperson.svg" alt="">
        </a>
        <a class="btn" href="#">
          <img src="imgs/icons/cart.svg" alt="">
        </a>
        <a class="btn" href="add_produto.html">
          <img src="imgs/icons/iconplus.svg" alt="">
        </a>
        <a class="btn" href="logica/logout.php">
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
          <li><a class="dropdown-item" href="contactos.php">Contactos</a></li>
          <li><a class="dropdown-item" href="faqs.html">FAQs</a></li>
          <li><a class="dropdown-item" href="#">Mais alguma cena aqui</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

  <!--Imagem principal-->
  <div class="container-fluid p-0" style="background-color: transparent;">
    <img class="object-fit-contain" src="imgs/hero_contactos.svg" style="object-fit: contain; width: 100%; height: 100%;" alt="">
  </div>
<form method="POST">
  <div class="container-fluid">
    <div class="row">
      <!--Coluna sem nada até lg-->
      <div class="col-1 d-none d-lg-block">
  
      </div>
      <div class="row">
      <div class="div mt-5 d-block d-lg-none">
        <p style="font-family:Jost; font-size: 16px">
          <img class="img-fluid me-5" src="imgs/icons/telephone-fill.svg" style="max-width: 30px; max-height: 30px; width: 100%;" alt="">
          Contacto: +351 910 452 535
        </p>
        <p style="font-family:Jost; font-size: 16px">
          <img class="img-fluid me-5" src="imgs/icons/mail.svg" style="max-width: 30px; max-height: 30px; width: 100%;" alt="">
          Email: cenaetal@support.pt
        </p>
        <p style="font-family:Jost; font-size: 16px">
          <img class="img-fluid me-5" src="imgs/icons/tiktok.svg" style="max-width: 30px; max-height: 30px; width: 100%;" alt="">
          Tiktok: Cena&Tal
        </p>
        <p style="font-family:Jost; font-size: 16px">
          <img class="img-fluid me-5" src="imgs/icons/instagram.svg" style="max-width: 30px; max-height: 30px; width: 100%;" alt="">
          Instagram: Cena_&_Tal
        </p>
      </div>
      </div>
      <!--Coluna das redes sociais até lg-->
      <div class="col d-none d-lg-block">
        <div class="div mt-5">
          <p style="font-family:Jost; font-size: 24px">
            <img class="img-fluid me-5" src="imgs/icons/telephone-fill.svg" style="max-width: 53px; max-height: 53px; width: 100%;" alt="">
            Contacto: +351 910 452 535
          </p>
          <p style="font-family:Jost; font-size: 24px">
            <img class="img-fluid me-5" src="imgs/icons/mail.svg" style="max-width: 53px; max-height: 53px; width: 100%;" alt="">
            Email: cenaetal@support.pt
          </p>
          <p style="font-family:Jost; font-size: 24px">
            <img class="img-fluid me-5" src="imgs/icons/tiktok.svg" style="max-width: 53px; max-height: 53px; width: 100%;" alt="">
            Tiktok: Cena&Tal
          </p>
          <p style="font-family:Jost; font-size: 24px">
            <img class="img-fluid me-5" src="imgs/icons/instagram.svg" style="max-width: 53px; max-height: 53px; width: 100%;" alt="">
            Instagram: Cena_&_Tal
          </p>
        </div>
      </div>
      <!--Coluna sem nada até lg-->
      <div class="col-1 d-none d-lg-block">
  
      </div>

      <!--Coluna dos inputs até lg-->
        <div class="col d-lg-block">
        <!--Nome e Email-->
        <div class="row mt-5">
          <!--Input do nome-->
          
          <div class="col">
            <p style="font-family:Jost; font-size: 24px; margin-bottom: 0px;">
              Nome:
            </p>
            <div class="input-group" style="height: 48px;">
              <input type="text" class="form-control rounded-3 border-1" style="background-color: #ECECEC; line-height: 0;font-family: Jost; border-color: black;" name="nome">
            </div>
          </div>
          <!--Input do Email-->
          <div class="col">
            <p style="font-family:Jost; font-size: 24px; margin-bottom: 0px;">
              Email:
            </p>
            <div class="input-group" style="height: 48px;">
              <input type="text" class="form-control rounded-3 border-1" style="background-color: #ECECEC; line-height: 0;font-family: Jost; border-color: black;" name="email">
            </div>
          </div>
        </div>
        <!--Input de Comentarios-->
          <div class="row me-3">
            <p style="font-family:Jost; font-size: 24px; margin-bottom: 0px;">
              Mensagem:
            </p>
          <textarea class="form-control rounded-3 border-1 ms-3 mb-1" style="background-color: #ECECEC; font-family: Jost; border-color: black; height: 217px; resize: vertical;" name="mensagem" required></textarea>
          </div>
          <button type="submit" class="btn mb-5">
            <img src="imgs/icons/enviar.svg" alt="">
          </button>
        </div>
      <!-- </form> -->
      <!--Coluna sem nada até lg-->
      <div class="col-1 d-none d-lg-block ">
  
      </div>
      <!--Conteúdo para Mobile-->
    </div>
  </form>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>