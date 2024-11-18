<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'db.php'; 

if (isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);

    $query = $conn->prepare("
        SELECT username, email, imagem, localidade, cidade, cp, telemovel, biografia, data 
        FROM users WHERE id = ?");
    $query->bind_param("i", $userId);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        echo "<p>User not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid user ID.</p>";
    exit;
}
?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilizador</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
 </head>
 <body style="background-color: #EAEAEA;">
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
          <li><a class="dropdown-item" href="contactos.php">Contactos</a></li>
          <li><a class="dropdown-item" href="faqs.html">FAQs</a></li>
          <li><a class="dropdown-item" href="#">Mais alguma cena aqui</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>


<div class="container mt-5">
    <div class="row">
        <div class="col-lg-3">
            <!-- User's Profile Image -->
            <img src="<?php echo htmlspecialchars($userData['imagem']); ?>" 
                 alt="Imagem de <?php echo htmlspecialchars($userData['username']); ?>" 
                 class="rounded-circle" style="width: 150px; height: 150px;">
        </div>
        <div class="col-lg-9">
            <h1 class="jomhuria-regular fs-custom">Perfil de <?php echo htmlspecialchars($userData['username']); ?></h1>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
            <p><strong>Localidade:</strong> <?php echo htmlspecialchars($userData['localidade']); ?></p>
            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($userData['cidade']); ?></p>
            <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($userData['cp']); ?></p>
            <p><strong>Telemóvel:</strong> <?php echo htmlspecialchars($userData['telemovel']); ?></p>
            <p><strong>Biografia:</strong> <?php echo nl2br(htmlspecialchars($userData['biografia'])); ?></p>
            <p><strong>Data de Criação:</strong> <?php echo htmlspecialchars($userData['data']); ?></p>
        </div>
    </div>
</div>


<script src="js/bootstrap.bundle.min.js"></script>
 </body>
 </html>