<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'includes/db.php'; 

$userData = [];

if (!$isLoggedIn) {
    header("Location: login.html");
    exit;
}

$userId = $_SESSION['user_id'];

$query = $conn->prepare("
    SELECT username, email, imagem, localidade, cidade, cp, telemovel, biografia 
    FROM users WHERE id = ?");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    header("Location: logica/error.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['nome'] ?? $userData['username'];
    $biografia = $_POST['biografia'] ?? $userData['biografia'];
    $localidade = $_POST['endereco'] ?? $userData['localidade'];
    $cidade = $_POST['cidade'] ?? $userData['cidade'];
    $cp = $_POST['cp'] ?? $userData['cp'];
    $telemovel = $_POST['telemovel'] ?? $userData['telemovel'];
    $email = $_POST['email'] ?? $userData['email'];
    $updateQuery = $conn->prepare("
        UPDATE users 
        SET username = ?, biografia = ?, localidade = ?, cidade = ?, cp = ?, telemovel = ?
        WHERE id = ?");
    $updateQuery->bind_param("ssssssi", $username, $biografia, $localidade, $cidade, $cp, $telemovel, $userId);

    if ($updateQuery->execute()) {
        // Refresh dados do user
        $userData['username'] = $username;
        $userData['biografia'] = $biografia;
        $userData['localidade'] = $localidade;
        $userData['cidade'] = $cidade;
        $userData['cp'] = $cp;
        $userData['telemovel'] = $telemovel;
        $userData['email'] = $email;
    } else {
        header("Location: logica/error.php");
    }
}
?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilizador</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="imgs/favicon.svg">
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
    <div class="col">
        <p class="jomhuria-regular fs-custom">Bem vindo ao seu perfil, <?php echo htmlspecialchars($userData['username']); ?>!</p>
        <div class="row rounded" style="background-color: white;">
            <div class="col-10 ms-4">
            <p class="jomhuria-regular fs-1 mt-4" style="line-height: 1;"><?php echo htmlspecialchars($userData['username']); ?></p>
            <p class="jomhuria-regular fs-2" style="line-height: 1;"><?php echo htmlspecialchars($userData['email']); ?></p>
            <p class="jomhuria-regular fs-3" style="line-height: 1;">
                <?php echo htmlspecialchars($userData['localidade'] . ', ' . $userData['cidade']); ?>
            </p>
            <div class="div rounded mb-4" style="background-color: #D9D9D9; height: 127px">
                <p class="jomhuria-regular fs-3 ms-3" style="line-height: 1;"><?php echo htmlspecialchars($userData['biografia']); ?></p>
            </div>
            

            </div>
            <div class="col mt-4">
                <a href="">
                    <img src="imgs/icons/account_circle.svg" style="height: 85px; width: 85px;" alt="">
                </a>
                <br>
                <a href="pagina_utilizador_guest.php?user_id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>" class="btn rounded-4 jomhuria-regular fs-3" style="background-color: black; color: white; line-height:0.75">
                    Perfil Público
                </a>
            </div>
            
        </div>
        <form method="POST">
        <div class="row mt-5 rounded" style="background-color: white;">
            <p class="jomhuria-regular fs-1 mt-4" style="line-height: 1;">Editar Perfil</p>
            <div class="col-4 ms-4">
                <p class="jomhuria-regular fs-2 mt-4" style="line-height: 1;">Nome: </p>
                <p class="jomhuria-regular fs-2 mt-5" style="line-height: 1;">Biografia: </p>
                <p class="jomhuria-regular fs-2 mt-4" style="line-height: 1;">Email: </p>
            </div>
            <div class="col mt-3">
                <div class="input-group ">
                    <input type="text" class="form-control rounded-4 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #d9d9d9; line-height: 0;"  
                        placeholder="Nome" value="<?php echo htmlspecialchars($userData['username']); ?>" name="nome">
                </div>
                <div class="input-group mt-4 mb-4">
                    <input type="text"  class="form-control rounded-4 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #d9d9d9; line-height: 0;"  
                        placeholder="Biografia" value="<?php echo htmlspecialchars($userData['biografia']); ?>" name="biografia">
                </div>
                <div class="input-group mt-4 mb-4">
                    <input type="email"  class="form-control rounded-4 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #d9d9d9; line-height: 0;"  
                        placeholder="email" value="<?php echo htmlspecialchars($userData['email']); ?>" name="email">
                </div>
            </div>
            <div class="col d-none d-lg-block">
                
            </div>
            <div class="row mb-4">
                <div class="col-10"></div>
            <div class="col">
                <button type="submit" class="btn rounded-4 jomhuria-regular fs-3" style="background-color: black; color: white; line-height:0.75">
                    Atualizar
                </button>
            </div>
        </div>
        </div>
        
    </form>

    <form method="POST">
        <div class="row mt-5 rounded mb-5" style="background-color: white;">
            <p class="jomhuria-regular fs-1 mt-4" style="line-height: 1;">Morada</p>
            <div class="col-4 ms-4">
                <p class="jomhuria-regular fs-2 mt-4" style="line-height: 1;">Endereço: </p>
                <p class="jomhuria-regular fs-2 mt-5" style="line-height: 1;">Cidade: </p>
                <p class="jomhuria-regular fs-2 mt-5" style="line-height: 1;">Código Postal: </p>
                <p class="jomhuria-regular fs-2 mt-5" style="line-height: 1;">Telemóvel: </p>
            </div>
            <div class="col mt-3">
                
                <!--Input de Endereço-->
                <div class="input-group ">
                    <input type="text" class="form-control rounded-4 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #d9d9d9; line-height: 0;" value="<?php echo htmlspecialchars($userData['localidade']); ?>" placeholder="Endereço" name="endereco">
                </div>
                <!--Input de Cidade-->
                <div class="input-group mt-4 mb-4">
                    <input type="text" class="form-control rounded-4 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #d9d9d9; line-height: 0;" placeholder="Cidade" value="<?php echo htmlspecialchars($userData['cidade']); ?>" name="cidade">
                </div>
                <!--Input de Código Postal-->
                <div class="input-group mt-5 mb-4">
                    <input type="text" class="form-control rounded-4 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #d9d9d9; line-height: 0;" placeholder="Código Postal" value="<?php echo htmlspecialchars($userData['cp']); ?>" name="cp">
                </div>
                <!--Input de Telemovel-->
                <div class="input-group mt-4 mb-4">
                    <input type="text" class="form-control rounded-4 jomhuria-regular fs-3 align-self-center me-5" style="background-color: #d9d9d9; line-height: 0;" placeholder="Telemóvel" value="<?php echo htmlspecialchars($userData['telemovel']); ?>" name="telemovel">
                </div>

            </div>

            <!--Coluna sem nada-->
            <div class="col d-none d-lg-block">

            </div>

            <div class="row mb-4">
                <div class="col-10">
                </div>
                <div class="col">
                    <button type="submit" class="btn rounded-4 jomhuria-regular fs-2" style="background-color: black; color: white; line-height: 1;">
                        Atualizar
                    </button>
                </div>
            </div>
            
        </div>
        </form>
        

    </div>


    <!--Mais duas colunas sem nada-->
    <div class="col-2 d-none d-lg-block">


    </div>

</div>


<script src="js/bootstrap.bundle.min.js"></script>
 </body>
 </html>