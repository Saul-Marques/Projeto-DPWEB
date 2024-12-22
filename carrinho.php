<?php
session_start();
include 'includes/db.php'; // Conexão à base de dados

// Verifica se o usuário está logado
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'] ?? null;

if ($isLoggedIn) {
    // Consulta para obter os produtos no carrinho do usuário
    $sql = "SELECT c.*, p.titulo, p.preco, pi.image_path 
            FROM carrinho c 
            JOIN produto p ON c.produto_id = p.id 
            LEFT JOIN produto_imagens pi ON p.id = pi.produto_id 
            WHERE c.user_id = ?";

    // Prepara e executa a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();



    // Fecha a declaração
    $stmt->close();
} else {
    echo '<p>Por favor, faça login para ver o seu carrinho.</p>';
}

// Fecha a conexão
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
</head>
<body style="background-color: #EAEAEA;">
    <?php include 'includes/navbar.php' ?>

    <div class="row ms-5 mt-5 me-5">
    <!--2 Colunas sem nada-->
    <div class="col-2 d-none d-lg-block">

    </div>
    <!--Coluna dos produtos -->
    <div class="col">


    </div>
    <!--Coluna do total -->
    <div class="col">

    </div>
    <!--2 Colunas sem nada-->
    <div class="col-2 d-none d-lg-block">

    </div>

    </div>


    <?php include 'includes/footer.html' ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>