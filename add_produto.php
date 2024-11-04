<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();




if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $price = $_POST['preco'];
        // Verifica se o preço excede o limite
        if ($price > 999999) {
            echo "Preço excede o limite de 999999€.";
            exit; 
        }
    }
    
    
    $sql = "INSERT INTO produto (user_id, titulo, descricao, preco) VALUES ('$user_id', '$titulo', '$descricao', '$preco')";
    if ($conn->query($sql) === TRUE) {
        $produto_id = $conn->insert_id; 

$target_dir = "imgs/";
$images = $_FILES['imagens'];

for ($i = 0; $i < count($images['name']); $i++) {
    if ($i >= 7) break;

    $image_name = basename($images['name'][$i]);
    $target_file = $target_dir . $image_name;
    $tmp_name = $images['tmp_name'][$i];

    if (getimagesize($tmp_name)) {
        if (move_uploaded_file($tmp_name, $target_file)) {
            $image_sql = "INSERT INTO produto_imagens (produto_id, image_path) VALUES ('$produto_id', '$target_file')";
            $conn->query($image_sql);
        } else {
            echo "Erro ao enviar os ficheiros: " . $image_name;
        }
    } else {
        echo "Ficheiro não é uma imagem válida: " . $image_name;
    }
}


        if ($first_image_path) {
            $cover_sql = "UPDATE produto SET imagem = '$first_image_path' WHERE id = '$produto_id'";
            $conn->query($cover_sql);
        }

        echo "Produto adicionado com sucesso!";
        header('Location: index.php');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
