<?php
include '../includes/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit();
}

if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['preco'] < 9999)) {
    $user_id = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Insert the product into the database
    $sql = "INSERT INTO produto (user_id, titulo, descricao, preco) VALUES ('$user_id', '$titulo', '$descricao', '$preco')";
    if ($conn->query($sql) === TRUE) {
        $produto_id = $conn->insert_id; 

        // Create a custom folder for the product images
        $target_dir = "imgs/produtos/" . $produto_id . "/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }

        $images = $_FILES['imagens'];
        for ($i = 0; $i < count($images['name']); $i++) {
            if ($i >= 7) break;

            $image_name = basename($images['name'][$i]);
            $target_file = $target_dir . $image_name; // Update the target file path
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

        // Optionally set the first image as the cover image
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
    header("Location: add_produto.html");
}