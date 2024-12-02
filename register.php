<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
</head>
<body>
    <body style="background-color: #EAEAEA;">
        <nav class="navbar navbar-expand-lg" style="background-color: black;">
          <div class="container-fluid">
            <a class="navbar-brand align-self-center"  href="index.html">
              <img src="imgs/logo.svg"  style="width:69px;" alt="">
            </a>
          </div>
        </nav>
      
        <div class="container p-0 rounded mt-5" style="background-color: white; height: 698px; overflow: hidden;">
            <div class="row">
                <div class="col-6 d-none d-lg-block">
                    <img class="img-fluid d-none d-lg-block p-0 g-0 rounded-start object-fit-cover" style="object-fit:fill;" src="imgs/noise2.jpg" alt="">
                </div>
                <div class="col-6">
                    <h3 class="jomhuria-regular fs-custom mt-5">Registado com sucesso!</h3>
                    <br>
                        <h5>
                          <a class="btn rounded-4 jomhuria-regular fs-1" style="color: white; background-color: black" href="login.html">Login</a>
                         </h5>
                    
                    
                </div>  
            </div>  
        </div>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
