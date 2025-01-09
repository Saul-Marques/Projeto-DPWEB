<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $userId = $_SESSION['user_id'];

    // procura pelo estado visivel do produto
    $check_sql = "SELECT visivel FROM produto WHERE id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $productId, $userId);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $product = $check_result->fetch_assoc();
        $newVisibility = ($product['visivel'] == 1) ? 0 : 1; // altera a visibilidade

        // Atualiza o campo 'visivel' para mostrar o status
        $update_sql = "UPDATE produto SET visivel = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("iii", $newVisibility, $productId, $userId);
        
        if ($stmt->execute()) {
            // Manda o user de volta
            header("Location: ../pagina_utilizador_guest.php?user_id=" . $userId);
            exit;
        } else {
            // Handle error
            header("Location: ../error.php");
        }
    } else {
        header("Location: ../error.php");
    }
}
?>