<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHPflix</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css"> </head>

<body>
  <?php include "header.php"; ?>

  <main>
    <div class="container">
      <div class="jumbotron text-center">
        <h1 class="display-4">Bem-vindo ao PHPflix</h1>
        <p class="lead">Seu lugar para os melhores filmes e séries.</p>
      </div>

      <?php

      // Conectar ao banco de dados
      $banco = new mysqli("localhost", "root", "", "phpflix_db");

      // Verificar conexão
      if ($banco->connect_error) {
        die("Conexão falhou: " . $banco->connect_error);
      }

      // Consulta para contar filmes
      $sql_filmes_total = "SELECT COUNT(*) AS total_filmes FROM filmes";
      $resultado_filmes_total = $banco->query($sql_filmes_total);

      // Verificar e exibir o total de filmes
      if ($resultado_filmes_total->num_rows > 0) {
        $row_total = $resultado_filmes_total->fetch_assoc();
        $total_filmes = $row_total['total_filmes'];
        echo "<p class='text-center'>Atualmente temos <strong>$total_filmes</strong> filmes em nosso catálogo.</p>";
      } else {
        echo "<p class='text-center'>Nenhum filme encontrado no catálogo.</p>";
      }

      // Consulta para obter filmes (limited to 24)
      $sql_filmes = "SELECT id, nome, capa FROM filmes LIMIT 24";
      $resultado_filmes = $banco->query($sql_filmes);

      // Exibir filmes
      if ($resultado_filmes) { // Check if query was successful
        if ($resultado_filmes->num_rows > 0) {
          echo "<div class='movie-list'>"; // Start a container for the movie list
          while ($filme = $resultado_filmes->fetch_assoc()) {
            $movie_id = $filme['id'];
            $movie_title = $filme['nome'];
            $image_data = $filme['capa']; // Assuming image data is stored in a column named 'imagem'

            // Encode the image data to Base64
            $base64_image = base64_encode($image_data);

            echo "
              <div class='movie-card'>
                <img src='data:image/jpeg;base64,$base64_image' class='card-img-top' alt='$movie_title'>
                <div class='card-body'>
                  <h5 class='card-title'>$movie_title</h5>
                </div>
              </div>
            ";
          }
          echo "</div>"; // End the movie list container
        } else {
          echo "<p class='text-center'>Nenhum filme encontrado no catálogo.</p>";
        }
      } else {
        echo "<p class='text-center'>Erro ao buscar filmes.</p>"; // Handle query errors
      }

      // Close connection
      $banco->close();
      ?>

    </div>
  </main>
  <footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 PHPflix. Todos os direitos reservados.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2
