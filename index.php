<?php
//apagar este display de erros depois de acabar o desenvolvimento
error_reporting(E_ALL);
ini_set('display_errors', 1);

$isLoggedIn = isset($_SESSION['user_id']);
include 'includes/db.php'; // Conexão à base de dados

// Procurar produtos na base de dados
$sql = "SELECT produto.*, produto_imagens.image_path, users.username 
        FROM produto 
        LEFT JOIN produto_imagens ON produto.id = produto_imagens.produto_id 
        LEFT JOIN users ON produto.user_id = users.id 
        GROUP BY produto.id 
        ORDER BY MIN(produto_imagens.id)";

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabalho DPWEB</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
    
</head>
<body style="background-color: #EAEAEA;">
<!-- Navbar -->
 <?php include 'includes/navbar.php' ?>

  <!--Imagem principal-->
<div class="container-fluid p-0 rounded" style="background-color: transparent;">
  <img class="object-fit-contain" src="imgs/cover2.png" style="object-fit: contain; width: 100%; height: 100%;" alt="">
    
  <div class="input-group " style="position: absolute; bottom: 80%; left: 10%;; width: 75%;">
    <input type="text" class="form-control d-none d-md-block  rounded-start-pill  border-end-0 border-black" placeholder="Pesquisa" aria-label="Pesquisa" aria-describedby="button-pesquisa1">
    <button class="btn d-none d-md-block rounded-end-pill  border-black border-start-0" type="button" id="button-pesquisa1" style="background-color: white; height: 55px;">
      <img src="imgs/icons/iconpesquisa.svg" style="margin-bottom: 3px;" alt="">
    </button>
  </div>

  </div>

  <div class="input-group mt-3">
    <input type="text" class="form-control d-block d-md-none  rounded-start-pill  border-end-0 border-black" placeholder="Pesquisa" aria-label="Pesquisa" aria-describedby="button-pesquisa1">
    <button class="btn d-block d-md-none rounded-end-pill  border-black border-start-0" type="button" id="button-pesquisa1" style="background-color: white; height: 55px;">
      <img src="imgs/icons/iconpesquisa.svg" style="margin-bottom: 3px;" alt="">
    </button>
  </div>


  <!--Slogan-->
  <div class="container rounded text-center jomhuria-regular fs-custom" style="background-color: transparent;">
    Cena&Tal – Comprar e vender, nunca foi tão natural!
  </div>
  <!--Categorias-->

  <div class="container-fluid ms-auto me-auto" style="background-color: #D9D9D9; margin-top: 40px;">
  </div>
  <!--Começa o display das cards-->
  <div class="container-fluid mt-5 mb-5 ">
    <div class=" container-fluid mt-5 mb-5 row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gy-4 mx-auto">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="col me-0">
        <div class="card rounded-2" style="width: 100%; height: 400px; background-color: white;">
          <a href="pagina_utilizador_guest.php?user_id=<?php echo htmlspecialchars($row['user_id']); ?>" class="card-header border-0 bg-transparent mt-1" style="text-decoration: none">
              <?php echo htmlspecialchars($row['username']); ?>
          </a>
          <a href="pagina_produto.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="text-decoration-none">
            <div class="container p-0" style="width: 100%; height: 250px; background-color: white;">
              <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="img-fluid" alt="Product Image" style="width: 100%; height: 100%; object-fit:cover;">
            </div>
          </a>
          <div class="card-body">
            <a href="pagina_produto.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="text-decoration-none " style="color: #000000">
              <div class="card-title"><?php echo htmlspecialchars($row['titulo']); ?></div>
            </a>
            <div class="card-text"><h5 class="fw-bold"><?php echo htmlspecialchars($row['preco']); ?>€</h5></div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
</div>
<h1 class="text-center mt-5 mb-5 jomhuria-regular fs-custom" style="color: rgba(150, 150, 150, 0.425);">Chegou ao fim...</h2>
  <!--Footer-->
    <footer style="background-color: black; color: white;">
      <div class="container">
        <div class="row row-cols-2">
          <!--Coluna da esquerda-->
          <div class="col">
            <img src="imgs/logo.svg" class="mt-5 mb-5" alt="">
          </div>
          <div class="col">
            <p class="mt-3" style="color: #c4c4c4;"> Informações</p>
            <a class="btn" style="color: #ffffff;" href="faqs.html"> FAQs</a>
            <br>
            <a class="btn" style="color: #ffffff;" href="contactos.php"> Contactos</a>
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