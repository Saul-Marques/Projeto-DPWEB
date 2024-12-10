<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'includes/db.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details
    $sql = "SELECT p.*, u.username,u.id,u.imagem, pi.image_path 
            FROM produto p 
            JOIN users u ON p.user_id = u.id
            LEFT JOIN produto_imagens pi ON p.id = pi.produto_id 
            WHERE p.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Fetch all images for the product
    $images_query = $conn->prepare("SELECT image_path FROM produto_imagens WHERE produto_id = ?");
    $images_query->bind_param("i", $productId);
    $images_query->execute();
    $images_result = $images_query->get_result();

    if (!$product) {
        echo "Produto não encontrado";
        exit;
    }

    // Procurar o maior bid (maior_valor)
    $bid_query = $conn->prepare("SELECT MAX(valor) AS maior_valor FROM bids WHERE produto_id = ?");
    $bid_query->bind_param("i", $productId);
    $bid_query->execute();
    $bid_result = $bid_query->get_result();
    $bid_data = $bid_result->fetch_assoc();
    $maior_valor = $bid_data['maior_valor'] ?? 0; // Default é 0 se não houver bids

    $bid_history_query = $conn->prepare("
    SELECT b.valor, b.timestamp, u.username 
    FROM bids b
    JOIN users u ON b.user_id = u.id
    WHERE b.produto_id = ?
    ORDER BY b.timestamp DESC
    ");
    $bid_history_query->bind_param("i", $productId);
    $bid_history_query->execute();
    $bid_history_result = $bid_history_query->get_result();

    // Handle à submissão
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bid']) && $isLoggedIn) {
        $valor = floatval($_POST['bid']);
        $userId = $_SESSION['user_id'];

        if ($valor > $maior_valor) {
            $insert_bid = $conn->prepare("INSERT INTO bids (produto_id, user_id, valor) VALUES (?, ?, ?)");
            $insert_bid->bind_param("iid", $productId, $userId, $valor);
            if ($insert_bid->execute()) {
                $maior_valor = $valor; // Atualiza a maior bid
                echo "<script>alert('Lance registado com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao registar o lance.');</script>";
            }
        } else {
            echo "<script>alert('O lance deve ser maior que o valor atual.');</script>";
        }
    }
} else {
    echo "Sem ID do produto";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
</head>
<body style="background-color: #EAEAEA;">
<!-- Navbar -->
<nav class="navbar navbar-expand-sm" style="background-color: black;">
    <div class="container-fluid">
      <a class="navbar-brand align-self-center" href="index.php">
        <img src="imgs/logo.svg" style="width:69px;" alt="">
      </a>
      <div class="d-flex align-items-center">
        <!-- Icons são apresantados se o user estiver logado -->
        <?php if ($isLoggedIn == true): ?>
          <a class="btn" href="pagina_utilizador.php">
            <img src="imgs/icons/iconperson.svg" alt="">
          </a>
          <a class="btn" href="#">
            <img src="imgs/icons/cart.svg" alt="">
          </a>
          <a class="btn" href="add_produto.html">
            <img src="imgs/icons/iconplus.svg" alt="">
          </a>
          <a class="btn" href="logica/logout.php">
            <img src="imgs/icons/logout.svg" style="width:20px; height:20px;" alt="">
          </a>
        <!-- 'Login' e 'Registar' serão apresentados se o user nao estiver logado -->
        <?php else: ?>
          <a class="btn jomhuria-regular fs-2" style="color: white;" href="login.html">Login</a>
          <a class="btn jomhuria-regular fs-2" style="color: white;" href="registar.html">Registar</a>
        <?php endif; ?>
  
        <!-- Context menu -->
        <div class="dropstart ms-3">
          <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: black;">
            <img src="imgs/icons/iconcont.svg" alt="">
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="contactos.html">Contactos</a></li>
            <li><a class="dropdown-item" href="faqs.html">FAQs</a></li>
            <li><a class="dropdown-item" href="#">Mais alguma cena aqui</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav> 

  <div class="row ms-5 mt-5 me-5">
    <!--Coluna sem nada-->
    <div class="col-1 d-none d-lg-block">

    </div>
    <!--Coluna das imagens e da descricao-->
    <div class="col">
      
        <div class="row rounded" style="background-color: #D9D9D9; height: 517px;">             
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $active = "active";
                    while ($image = $images_result->fetch_assoc()):
                    ?>
                        <div class="carousel-item text-center <?php echo $active; ?>">
                          <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="Product Image" style="height: 517px;width:100%; object-fit: contain;">
                        </div>
                    <?php
                    $active = "";
                    endwhile;
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        
      <div class="d-block d-lg-none mt-3">
      <div class="row rounded" style="background-color: white;">
        <div class="col">
          <p class="jomhuria-regular fs-4 g-0 mb-0 mt-2" style="line-height: 1; color: #2C2C2C;">
            Publicado a: <?php echo htmlspecialchars($product['adicionado_a']);?>
          </p>
          <p class="jomhuria-regular fs-1">
            Utilizador: 
          <a href="pagina_utilizador_guest.php?user_id=<?php echo htmlspecialchars($product['id']); ?>" class="jomhuria-regular fs-1" style="text-decoration: none; color:#000000">
              <?php echo htmlspecialchars($product['username']); ?>
          </a>
          </p>
            <p class="jomhuria-regular fs-1">
                Preço: <?php echo htmlspecialchars($product['preco']); ?>€
            </p>
          <p class="jomhuria-regular fs-1" style="line-height: 1;">
            Licitação atual: <?php echo htmlspecialchars($maior_valor); ?>€
          </p>
          <p class="jomhuria-regular fs-4 g-0 mb-0 mt-2" style="line-height: 0; color: #5E5E5E;">
            Termina em:
          </p>
          <br>
          <form method="POST">
          <div class="input-group">
            <input type="text" class="form-control rounded-4 border-1 jomhuria-regular fs-3 align-self-center me-5" id="bid" min="<?php echo $maior_valor + 0.01; ?>" style="background-color: #BBBBBB; line-height: 0; border-color: black;" placeholder="Valor a licitar" name="bid">
          </div>
          <button type="submit" class="btn rounded-4 border-1 jomhuria-regular fs-1 align-self-center me-5 mt-3" style="background-color: #BBBBBB; border-color: black; width: 100%; line-height: 1;">
            Licitar
          </button>
          </form>

          <div class="btn rounded-4 border-0 jomhuria-regular fs-1 align-self-center me-5 mb-3 mt-3" style="background-color: #000000; width: 100%; line-height: 1; color: white;">
            Comprar agora.
          </div>
        </div>
        
      </div>
      <div class="row rounded mt-3" style="background-color: white;">
        <div class="col">
          <p class="jomhuria-regular fs-1" style="line-height: 1; color: #5E5E5E;">
            Do Utilizador: 
          </p>
          <p class="jomhuria-regular fs-custom" style="line-height: 1; color: #000000;">
            <img src="<?php echo htmlspecialchars($product['imagem']); ?>" alt="">
            <a href="pagina_utilizador_guest.php?user_id=<?php echo htmlspecialchars($product['id']); ?>" style="text-decoration:none; color: black">
              <?php echo htmlspecialchars($product['username']); ?>
            </a>
            
          </p>
          <p class="jomhuria-regular fs-1" style="line-height: 1; color: #000000;">
            Ultimas licitações:
          </p>
          <pre class="jomhuria-regular fs-3 mb-5" style="line-height: 1; color: #5E5E5E;">(nome de utilizador) Há 00h                                10.00€</pre>
        </div>
        
      </div>
    </div>
        <div class="row rounded mt-3 mb-5" style="background-color: white;">
            
                <p class="jomhuria-regular fs-custom ms-3 mb-0 g-0">
                    <?php echo htmlspecialchars($product['titulo']); ?>
                    <a href="">
                      <img src="imgs/icons/bookmark.svg" style="width: 28px; height: 28px;" alt="">
                    </a>
                </p>
                <p class="jomhuria-regular ms-3 fs-1 mt-0" style="color: #D9D9D9;">
                    Descrição: 
                </p>
                <p class="jomhuria-regular fs-1 ms-3 mb-5"><?php echo htmlspecialchars($product['descricao']); ?></p>
        </div>
    </div>
    <!--Coluna das licitacoes e utilizador-->
    <div class="col-3 d-none d-lg-block ms-3">
      <div class="row rounded" style="background-color: white;">
        <div class="col">
          <p class="jomhuria-regular fs-4 g-0 mb-0 mt-2" style="line-height: 1; color: #2C2C2C;">
            Publicado a: <?php echo htmlspecialchars($product['adicionado_a']);?>
          </p>
          <p class="jomhuria-regular fs-1">
            Utilizador: 
          <a href="pagina_utilizador_guest.php?user_id=<?php echo htmlspecialchars($product['id']); ?>" class="jomhuria-regular fs-1" style="text-decoration: none; color:#000000">
              <?php echo htmlspecialchars($product['username']); ?>
          </a>
          </p>
            <p class="jomhuria-regular fs-1">
                Preço: <?php echo htmlspecialchars($product['preco']); ?>€
            </p>
          <p class="jomhuria-regular fs-1" style="line-height: 1;">
          Licitação atual: <?php echo htmlspecialchars($maior_valor); ?>€
          </p>
          <p class="jomhuria-regular fs-4 g-0 mb-0 mt-2" style="line-height: 0; color: #5E5E5E;">
            Termina em:
          </p>
          <br>
          <form method="POST">
          <div class="input-group">
            <input type="text" class="form-control rounded-4 border-1 jomhuria-regular fs-3 align-self-center me-5" id="bid" min="<?php echo $maior_valor + 0.01; ?>" style="background-color: #BBBBBB; line-height: 0; border-color: black;" placeholder="Valor a licitar" name="bid">
          </div>
          <button type="submit" class="btn rounded-4 border-1 jomhuria-regular fs-1 align-self-center me-5 mt-3" style="background-color: #BBBBBB; border-color: black; width: 100%; line-height: 1;">
            Licitar
          </button>
          </form>
          <button class="btn rounded-4 border-0 jomhuria-regular fs-1 align-self-center me-5 mb-3 mt-3" style="background-color: #000000; width: 100%; line-height: 1; color: white;">
            Comprar agora.
          </button>
        </div>
        
      </div>
      <div class="row rounded mt-3" style="background-color: white;">
        <div class="col">
          <p class="jomhuria-regular fs-1" style="line-height: 1; color: #5E5E5E;">
            Do Utilizador: 
          </p>
          <p class="jomhuria-regular fs-custom" style="line-height: 1; color: #000000;">
            <img src="<?php echo htmlspecialchars($product['imagem']); ?>" alt="">
            <a href="pagina_utilizador_guest.php?user_id=<?php echo htmlspecialchars($product['id']); ?>" style="text-decoration:none; color: black">
              <?php echo htmlspecialchars($product['username']); ?>
            </a>
          </p>
          <p class="jomhuria-regular fs-1" style="line-height: 1; color: #000000;">
            Ultimas licitações:
          </p>
          <?php while ($bid = $bid_history_result->fetch_assoc()): ?>
    <pre class="jomhuria-regular fs-3 mb-5" style="line-height: 1; color: #5E5E5E;"><?php echo htmlspecialchars($bid['username']); ?>       <?php 
            $timeElapsed = time() - strtotime($bid['timestamp']);
            $hoursElapsed = floor($timeElapsed / 3600);
            echo "há {$hoursElapsed}h";
        ?> <?php echo number_format($bid['valor'], 2); ?>€
    </>
<?php endwhile; ?></pre>
        </div>
        
      </div>
    </div>
  </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>