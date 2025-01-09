<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['preco'] < 99999)) {
    $user_id = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Inserir o produto na base de dados
    $sql = "INSERT INTO produto (user_id, titulo, descricao, preco) VALUES ('$user_id', '$titulo', '$descricao', '$preco')";
    if ($conn->query($sql) === TRUE) {
        $produto_id = $conn->insert_id; 
        // Criar uma pasta para cada produto baseado no produto_id
        $target_dir = "imgs/produtos/" . $produto_id . "/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

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

        // A primeira imagem é a capa
        if (isset($images['name'][0])) {
            $first_image_path = $target_dir . basename($images['name'][0]);
            $cover_sql = "UPDATE produto SET imagem = '$first_image_path' WHERE id = '$produto_id'";
            $conn->query($cover_sql);
        }

        echo "Produto adicionado com sucesso!";
        header('Location: index.php');
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: error.php");
}