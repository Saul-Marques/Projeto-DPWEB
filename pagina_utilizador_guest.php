<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'includes/db.php'; 

if (isset($_GET['user_id'])) {
    $userId = intval($_GET['user_id']);
    
    $query = $conn->prepare("
        SELECT username, email, imagem, localidade, cidade, cp, telemovel, biografia, data 
        FROM users WHERE id = ?");
    $query->bind_param("i", $userId);
    $query->execute();
    $result = $query->get_result();
    $product_sql = "SELECT produto.*, produto_imagens.image_path, users.username 
        FROM produto 
        LEFT JOIN produto_imagens ON produto.id = produto_imagens.produto_id 
        LEFT JOIN users ON produto.user_id = users.id 
        WHERE produto.user_id = $userId
        GROUP BY produto.id 
        ORDER BY MIN(produto_imagens.id)";

  $product_result = $conn->query($product_sql);


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
    <link rel="icon" type="image/x-icon" href="imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
 </head>
 <body style="background-color: #EAEAEA;">
 <?php include 'includes/navbar.php' ?>



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
            <p><strong>Membro desde:</strong> <?php echo htmlspecialchars($userData['data'] ?? ''); ?></p>
            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($userData['cidade'] ?? ''); ?></p>
            <p><strong>Biografia:</strong> <?php echo nl2br(htmlspecialchars($userData['biografia'] ?? '')); ?></p>
            
        </div>
    </div>
</div>


<div class="container-fluid mt-5 mb-5 ">
    <div class=" container-fluid mt-5 mb-5 row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-1 gy-4 mx-auto">
    <?php while($row = $product_result->fetch_assoc()): ?>
      <div class="col me-0">
        <div class="card rounded-2" style="width: 100%; height: 400px; background-color: white;">
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


<script src="js/bootstrap.bundle.min.js"></script>
 </body>
 </html>
