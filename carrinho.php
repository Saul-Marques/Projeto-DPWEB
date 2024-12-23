<?php
session_start();
include 'includes/db.php'; // Conexão à base de dados

// Verifica se o usuário está logado
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id'] ?? null;

// Lógica para remover um item do carrinho
if (isset($_POST['remove_item'])) {
    $itemId = $_POST['item_id'];
    $remove_sql = "DELETE FROM carrinho WHERE id = ? AND user_id = ?";
    $remove_stmt = $conn->prepare($remove_sql);
    $remove_stmt->bind_param("ii", $itemId, $userId);
    $remove_stmt->execute();
    $remove_stmt->close();
}


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

    <div class="container mt-5">
        <h2 class="jomhuria-regular fs-1 text-center">O seu carrinho.</h2>
        <div class="row">
            <!-- Coluna dos produtos -->
            <div class="col-12 col-lg-8">
                <div class="container mt-3">
                    <?php if ($isLoggedIn && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="row rounded-3 mb-3 align-items-stretch" style="background-color:white">
                                <!-- Coluna da imagem -->
                                <div class="col-12 col-md-4">
                                    <div class="container p-0 mt-3">
                                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="img-fluid rounded-4" alt="Product Image">
                                    </div>
                                </div>
                                <!-- Coluna da informação do produto -->
                                <div class="col-12 col-md-8">
                                    <p class="jomhuria-regular fs-2"><?php echo htmlspecialchars($row['titulo']); ?></p>
                                    <p class="jomhuria-regular fs-1" style="line-height:0"><?php echo htmlspecialchars($row['preco']); ?>€</p>
                                    <?php
                                        // Consulta para obter a maior bid do produto
                                        $productId = $row['produto_id'];
                                        $bid_sql = "SELECT MAX(valor) AS maior_valor FROM bids WHERE produto_id = ?";
                                        $bid_stmt = $conn->prepare($bid_sql);
                                        $bid_stmt->bind_param("i", $productId);
                                        $bid_stmt->execute();
                                        $bid_result = $bid_stmt->get_result();
                                        $bid_data = $bid_result->fetch_assoc();
                                        $maior_valor = $bid_data['maior_valor'] ?? 0; // Default é 0 se não houver bids
                                    ?>
                                    <p class="jomhuria-regular fs-2" style="line-height:1">Licitação atual: <?php echo htmlspecialchars($maior_valor); ?>€</p>
                                    <a href="pagina_produto.php?id=<?php echo htmlspecialchars($row['produto_id']); ?>" class="btn rounded-4 border-0 jomhuria-regular fs-1" style="background-color: #000000; color: white; line-height:1">
                                        Alterar Licitação.
                                    </a>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <button type="submit" name="remove_item" class="btn border-0 jomhuria-regular fs-4 " style="background-color: white; color: grey; line-height:1">
                                            Remover
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="jomhuria-regular fs-4 text-center">O seu carrinho está vazio...</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Coluna do total -->
            <div class="col-12 col-lg-4">
                <h2 class="jomhuria-regular fs-2">Total.</h2>
                <div>
                    <!-- Aqui você pode adicionar o cálculo do total -->
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.html' ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>