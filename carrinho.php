<?php
session_start();
include 'includes/db.php'; // Conexão à base de dados

// Verifica se o usuário está logado
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'] ?? null;

// Consulta para obter as licitações que o usuário participa
$sql = "SELECT b.*, p.titulo, p.preco, pi.image_path 
        FROM bids b 
        JOIN produto p ON b.produto_id = p.id 
        LEFT JOIN produto_imagens pi ON p.id = pi.produto_id 
        WHERE b.user_id = ? 
        GROUP BY b.produto_id 
        ORDER BY b.licitado_a DESC";

// Prepara e executa a consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Inicializa as variáveis
$total = 0;
$totalBids = 0;

// Loop para coletar os dados das licitações
while ($row = $result->fetch_assoc()) {
    // Atualiza o total de licitações
    $total += $row['valor'];
    $totalBids++;
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
    <link rel="icon" type="image/x-icon" href="imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-color: #EAEAEA;">
    <?php include 'includes/navbar.php' ?>

    <div class="container mt-5">
        <h2 class="jomhuria-regular fs-custom text-center">As suas licitações.</h2>

        <img id="hiddenImage" src="imgs/elRxCnaZ_400x400.jpg" alt="Imagem de Checkout" />
        <div class="row">
            <!-- Coluna dos produtos -->
            <div class="col-12 col-lg-8">
                <div class="container mt-3">
                    <?php 
                    // Reabre a conexão
                    include 'includes/db.php';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($isLoggedIn && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="row rounded-3 mb-3 align-items-stretch" style="background-color:white">
                                <!-- Coluna da imagem -->
                                <div class="col-12 col-md-4">
                                    <div class="container p-0 mt-3 mb-3">
                                        <a href="pagina_produto.php?id=<?php echo htmlspecialchars($row['produto_id']); ?>">
                                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="img-fluid rounded-4 " alt="Product Image">
                                        </a>
                                    </div>
                                </div>
                                <!-- Coluna da informação do produto -->
                                <div class="col-12 col-md-8">
                                    <a href="pagina_produto.php?id=<?php echo htmlspecialchars($row['produto_id']); ?>" style="text-decoration:none; color:black" class="jomhuria-regular fs-2"><?php echo htmlspecialchars($row['titulo']); ?></a>
                                    <p class="jomhuria-regular fs-1" style="line-height:0"><?php echo htmlspecialchars($row['preco']); ?>€</p>
                                    <p class="jomhuria-regular fs-2" style="line-height:1">A sua licitação: <?php echo htmlspecialchars($row['valor']); ?>€</p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="jomhuria-regular fs-4 text-center">O seu carrinho está vazio...</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Coluna do total -->
            <div class="col-12 col-lg-4 mt-3 rounded-3" style="background-color:white; height:300px; margin-bottom: 20px;">
                <h3 class="jomhuria-regular fs-1">Total das Licitações</h3>
                <div class="">
                    <h4 class="jomhuria-regular fs-2"><?php echo $totalBids > 0 ? htmlspecialchars($total) . "€" : "0€"; ?></h4>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.html'; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>