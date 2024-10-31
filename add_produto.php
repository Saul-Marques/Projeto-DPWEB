<?php
include 'db.php';
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Insert the product into the `produto` table
    $sql = "INSERT INTO produto (user_id, titulo, descricao, preco) VALUES ('$user_id', '$titulo', '$descricao', '$preco')";
    if ($conn->query($sql) === TRUE) {
        $produto_id = $conn->insert_id; // Get the inserted product's ID

        // Handle multiple image uploads
// Directory where images will be uploaded
$target_dir = "imgs/";
$images = $_FILES['imagens'];

for ($i = 0; $i < count($images['name']); $i++) {
    if ($i >= 7) break;

    $image_name = basename($images['name'][$i]);
    $target_file = $target_dir . $image_name;
    $tmp_name = $images['tmp_name'][$i];

    // Ensure the uploaded file is a valid image
    if (getimagesize($tmp_name)) {
        if (move_uploaded_file($tmp_name, $target_file)) {
            $image_sql = "INSERT INTO produto_imagens (produto_id, image_path) VALUES ('$produto_id', '$target_file')";
            $conn->query($image_sql);
        } else {
            echo "Error uploading image: " . $image_name;
        }
    } else {
        echo "File is not a valid image: " . $image_name;
    }
}



        // Update the produto table to set the cover image
        if ($first_image_path) {
            $cover_sql = "UPDATE produto SET imagem = '$first_image_path' WHERE id = '$produto_id'";
            $conn->query($cover_sql);
        }

        echo "Produto adicionado com sucesso!";
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
