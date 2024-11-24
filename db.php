<?php
$servername = "localhost";
$username = "web";
$password = "web";
$dbname = "Web1";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha ao conectar: " . $conn->connect_error);
}