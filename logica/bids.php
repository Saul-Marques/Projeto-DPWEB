<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bid']) && isset($_SESSION['user_id'])) {
    $productId = $_POST['product_id'];
    $userId = $_SESSION['user_id'];
    $bidValue = floatval($_POST['bid']);

    // Verificar se o produto existe
    $checkProductQuery = $conn->prepare("SELECT id FROM produto WHERE id = ?");
    $checkProductQuery->bind_param("i", $productId);
    $checkProductQuery->execute();
    $checkProductResult = $checkProductQuery->get_result();

    if ($checkProductResult->num_rows > 0) {
        // Verificar se o valor da licitação é maior que o valor atual
        $bid_query = $conn->prepare("SELECT MAX(valor) AS maior_valor FROM bids WHERE produto_id = ?");
        $bid_query->bind_param("i", $productId);
        $bid_query->execute();
        $bid_result = $bid_query->get_result();
        $bid_data = $bid_result->fetch_assoc();
        $maior_valor = $bid_data['maior_valor'] ?? 0;

        if ($bidValue > $maior_valor) {
            // Inserir a nova licitação na base de dados
            $stmt = $conn->prepare("INSERT INTO bids (produto_id, user_id, valor, licitado_a) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iid", $productId, $userId, $bidValue);

            try {
                if ($stmt->execute()) {
                    echo "<script>alert('Licitação realizada com sucesso!');</script>";
                } else {
                    echo "<script>alert('Erro ao realizar a licitação.');</script>";
                }
            } catch (mysqli_sql_exception $e) {
                echo "<script>alert('Erro ao realizar a licitação: " . $e->getMessage() . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('O valor da licitação deve ser maior que o valor atual.');</script>";
        }
    } else {
        echo "<script>alert('Produto não encontrado.');</script>";
    }

    $checkProductQuery->close();
}

// Redireciona para a página do produto
header('Location: ../pagina_produto.php?id=' . $_POST['product_id']);
exit;
?>