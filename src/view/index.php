<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHPflix</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .movie-card img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 5px;
    }

    .movie-card {
      margin-bottom: 15px;
      max-width: 300px;
      margin-left: auto;
      margin-right: auto;
      border-radius: 10px;
    }

    .card-body {
      min-height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-title {
      text-align: center;
    }
  </style>
</head>

<body>
  <?php include "header.php"; ?>

  <main>
    <div class="container">
      <div class="jumbotron text-center">
        <h1 class="display-4">Bem-vindo ao PHPflix</h1>
        <p class="lead">Seu lugar para os melhores filmes e séries.</p>
      </div>

      <?php
      require_once "../controller/banco.php";

      if ($banco->connect_error) {
        die("Conexão falhou: " . $banco->connect_error);
      }

      $sql_filmes_total = "SELECT COUNT(*) AS total_filmes FROM filmes";
      $resultado_filmes_total = $banco->query($sql_filmes_total);

      if ($resultado_filmes_total->num_rows > 0) {
        $row_total = $resultado_filmes_total->fetch_assoc();
        $total_filmes = $row_total['total_filmes'];
        echo "<p class='text-center'>Atualmente temos <strong>$total_filmes</strong> filmes em nosso catálogo.</p>";
      } else {
        echo "<p class='text-center'>Nenhum filme encontrado no catálogo.</p>";
      }

      $sql_filmes = "SELECT id, nome, imagem FROM filmes LIMIT 24";
      $resultado_filmes = $banco->query($sql_filmes);

      if ($resultado_filmes) { 
        if ($resultado_filmes->num_rows > 0) {
          echo "<div class='row'>"; 
          while ($filme = $resultado_filmes->fetch_assoc()) {
            $movie_id = $filme['id'];
            $movie_title = $filme['nome'];
            $image_data = $filme['imagem']; 
      
            $base64_image = base64_encode($image_data);

            echo "
              <div class='col-sm-6 col-md-4 col-lg-3 mb-4'>
                <div class='card movie-card'>
                  <img src='data:image/jpeg;base64,$base64_image' class='card-img-top' alt='$movie_title'>
                  <div class='card-body'>
                    <h5 class='card-title'>$movie_title</h5>
                  </div>
                </div>
              </div>
            ";
          }
          echo "</div>"; 
        } else {
          echo "<p class='text-center'>Nenhum filme encontrado no catálogo.</p>";
        }
      } else {
        echo "<p class='text-center'>Erro ao buscar filmes.</p>"; 
      }

      $banco->close();
      ?>
    </div>
  </main>
  <footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 PHPflix. Todos os direitos reservados.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>