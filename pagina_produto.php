<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
include 'includes/db.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Busca os detalhes do produto
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

    // Procura todas as imagens do produto
    $images_query = $conn->prepare("SELECT image_path FROM produto_imagens WHERE produto_id = ?");
    $images_query->bind_param("i", $productId);
    $images_query->execute();
    $images_result = $images_query->get_result();

    if (!$product) {
      header("Location: logica/error.php");
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
    SELECT b.valor, b.licitado_a, u.username 
    FROM bids b
    JOIN users u ON b.user_id = u.id
    WHERE b.produto_id = ?
    ORDER BY b.licitado_a DESC
    ");
    $bid_history_query->bind_param("i", $productId);
    $bid_history_query->execute();
    $bid_history_result = $bid_history_query->get_result();

   // Lógica para adicionar produto à tabela carrinho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_carrinho']) && $isLoggedIn) {
  $userId = $_SESSION['user_id'];

  // Verificar se o produto existe
  $checkProductQuery = $conn->prepare("SELECT id FROM produto WHERE id = ?");
  $checkProductQuery->bind_param("i", $productId);
  $checkProductQuery->execute();
  $checkProductResult = $checkProductQuery->get_result();

  if ($checkProductResult->num_rows > 0) {
      // O produto existe, agora podemos adicionar ao carrinho
      $stmt = $conn->prepare("INSERT INTO carrinho (user_id, produto_id) VALUES (?, ?)");
      $stmt->bind_param("ii", $userId, $productId);

      try {
          if ($stmt->execute()) {
              echo "<script>alert('Produto adicionado ao carrinho com sucesso!');</script>";
          } else {
              echo "<script>alert('Erro ao adicionar o produto ao carrinho.');</script>";
          }
      } catch (mysqli_sql_exception $e) {
          echo "<script>alert('Erro ao adicionar o produto ao carrinho: " . $e->getMessage() . "');</script>";
      }

      $stmt->close();
  } else {
      echo "<script>alert('Produto não encontrado.');</script>";
  }

  $checkProductQuery->close();
}

    // Handle à submissão da bid
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bid']) && $isLoggedIn) {
        $valor = floatval($_POST['bid']);
        $userId = $_SESSION['user_id'];

        if ($valor > $maior_valor) {
            $insert_bid = $conn->prepare("INSERT INTO bids (produto_id, user_id, valor) VALUES (?, ?, ?)");
            $insert_bid->bind_param("iid", $productId, $userId, $valor);
            if ($insert_bid->execute()) {
                $maior_valor = $valor; // Atualiza a maior bid
                echo "<script>alert('Lance registado com sucesso!');</script>";
                header("pagina_produto.php");
            } else {
                echo "<script>alert('Erro ao registar o lance.');</script>";
            }
        } else {
            echo "<script>alert('O lance deve ser maior que o valor atual.');</script>";
        }
    }
} else {
  header("Location: logica/error.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['titulo']) ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="icon" type="image/x-icon" href="imgs/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jomhuria&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fonts/customfonts.css">
</head>
<body style="background-color: #EAEAEA;">
<!-- Navbar -->
<?php include 'includes/navbar.php' ?>


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
          <button type="submit" name="add_carrinho" class="btn rounded-4 border-1 jomhuria-regular fs-1 align-self-center me-5 mt-3" style="background-color: #000000; border-color: black; width: 100%; line-height: 1;color: white;">
            Licitar
          </button>
          </form>

          <form method="POST">
            <input type="hidden" value="<?php echo htmlspecialchars($productId) ?>">
            <button type="submit" name="add_carrinho" class="btn rounded-4 border-0 jomhuria-regular fs-1 align-self-center me-5 mb-3 mt-3" style="background-color: #000000; width: 100%; line-height: 1; color: white;">
              Adicionar ao carrinho
            </button>
          </form>
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
          <button type="submit" class="btn rounded-4 border-1 jomhuria-regular fs-1 align-self-center me-5 mt-3" style="background-color: #000000; border-color: black; width: 100%; line-height: 1;color:white">
            Licitar.
          </button>
          </form>
          <form method="POST">
            <input type="hidden" value="<?php echo htmlspecialchars($productId) ?>">
            <button type="submit" name="add_carrinho" class="btn rounded-4 border-0 jomhuria-regular fs-1 align-self-center me-5 mb-3 mt-3" style="background-color: #000000; width: 100%; line-height: 1; color: white;">
              Adicionar ao carrinho
            </button>
          </form>
        </div>
        
      </div>
      <div class="row rounded mt-3" style="background-color: white;">
        <div class="col">
          <p class="jomhuria-regular fs-1" style="line-height: 1; color: #5E5E5E;">
            Do Utilizador : 
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
            <p class="jomhuria-regular fs-3 mb-5" style="line-height: 1; color: #5E5E5E;">
                <?php echo htmlspecialchars($bid['username']); ?>       
                <?php 
                    $timeElapsed = time() - strtotime($bid['licitado_a']); // Calculate elapsed time in seconds
                    if ($timeElapsed < 3600) { // Less than an hour
                        $minutesElapsed = floor($timeElapsed / 60);
                        echo "há {$minutesElapsed}m"; // Display in minutes
                    } else {
                        $hoursElapsed = floor($timeElapsed / 3600);
                        echo "há {$hoursElapsed}h"; // Display in hours
                    }
                ?> 
                <?php echo number_format($bid['valor'], 2); ?>€
            </p>
          <?php endwhile; ?>
        </div>
        
      </div>
    </div>
  </div>
  <?php include 'includes/footer.html' ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>