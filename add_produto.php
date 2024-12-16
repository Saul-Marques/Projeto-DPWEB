<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Anúncio</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">

</head>
<body style="background-color: #EAEAEA;">
<!-- Navbar -->
<?php include 'includes/navbar.php' ?>

      <h2 class="jomhuria-regular fs-custom mt-5 ms-5">Novo Anúncio</h2>

      <!--Categoria, Título e Preço-->
      <!--Começa os forms-->
      
      <form action="logica/add_produto.php" method="POST" enctype="multipart/form-data">
      <div class="container" style="background-color: white;">
        <h3 class="jomhuria-regular fs-1 ms-3 mt-5">Categoria</h3>
        <div class="dropdown">
            <select class="btn dropdown-toggle jomhuria-regular fs-2 fw-lighter ms-3" name="categoria" style="color: #5A5A5A; background-color: #D9D9D9;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <option class="jomhuria-regular fs-2" value="placeholder">placeholder</option>
                <option class="jomhuria-regular fs-2" value="placeholder">placeholder</option>
                <option class="jomhuria-regular fs-2" value="placeholder">placeholder</option>
            </select>   
        </div>

        <br>
        <div class="row row-cols">
        <div class="col mb-5">
        <h3 class="jomhuria-regular fs-1 ms-3 mt-5">Título</h3>
            <div class="container-fluid ms-0 p-0" >
                <div class="input-group ms-3">
                <input type="text" name="titulo" class="form-control rounded border-0 jomhuria-regular  fs-3 align-self-center" style="background-color: #D9D9D9;" placeholder="Titulo" aria-label="Titulo" required>
                </div>
            </div>
        </div>
        <div class="col mb-5">
            <h3 class="jomhuria-regular fs-1 ms-4 mt-5">Preço</h3>
            <div class="container">
                <div class="input-group ms-3">
                <input type="text" name="preco" step=".01" min="1" max="999999" required class="form-control rounded border-0 jomhuria-regular me-3 fs-3 align-self-center " style="background-color: #D9D9D9;" placeholder="Preço" aria-label="Preço" oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                </div>
            </div>
        </div>
        </div>
      </div>
      <!--Acaba-->
      <!--Descrição-->
      <div class="container" style="background-color: white;">
        <h3 class="jomhuria-regular fs-1 ms-3 mt-5">Descrição</h3>
            <div class="container ms-0 p-0" style="height: 178px; width: 75%;">
                <div class="input-group ms-3">
                <input type="text" name="descricao" required class="form-control rounded border-0 jomhuria-regular fs-3 align-self-center" style="background-color: #D9D9D9;"  placeholder="Descrição" aria-label="Descrição">
                </div>
            </div>  
      </div>
      <!--Acaba-->
      <!--Imagens-->
      <div class="container" style="background-color: white;">
        <h3 class="jomhuria-regular fs-1 ms-3 mt-5">Insira as imagens.</h3>
        <input type="file" class="form-control" name="imagens[]" multiple accept="image/*" style="width: 75%;">
      </div>
      <!--Acaba as imagens-->
      <!--Butao Submeter-->
      <button type="submit" class="btn jomhuria-regular fs-1 mb-4 rounded text-center mt-5 ms-5" style="background-color: black; color: white; width: 300px; height: 70px;">
        Submeter.
    </button>
    </form>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>