<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPflix</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Optional for additional styling -->
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

            // Conectar ao banco de dados
            $banco = new mysqli("localhost", "root", "", "phpflix_db");

            // Verificar conexão
            if ($banco->connect_error) {
                die("Conexão falhou: " . $banco->connect_error);
            }

            // Consulta para contar filmes
            $sql = "SELECT COUNT(*) AS total_filmes FROM filmes";
            $resultado = $banco->query($sql);

            // Verificar e exibir o resultado
            if ($resultado->num_rows > 0) {
                $row = $resultado->fetch_assoc();
                $total_filmes = $row['total_filmes'];
                echo "<p class='text-center'>Atualmente temos <strong>$total_filmes</strong> filmes em nosso catálogo.</p>";
            } else {
                echo "<p class='text-center'>Nenhum filme encontrado no catálogo.</p>";
            }

            // Consulta para obter filmes
            $sql_filmes = "SELECT id, nome FROM filmes LIMIT 24";
            $resultado_filmes = $banco->query($sql_filmes);
            ?>

            <section>
                <h2 class="text-center my-4">Destaques</h2>
                <div class="movie-carousel">
                    <?php
                    if ($resultado_filmes->num_rows > 0) {
                        while ($filme = $resultado_filmes->fetch_assoc()) {
                            echo "
                            <div class='movie-card'>
                                <img src='exibir_imagem.php?id=1' class='card-img-top' alt='STAR WARS IV: NEW HOPE'>
                                <div class='card-body'>
                                    <h5 class='card-title'>STAR WARS IV: NEW HOPE</h5>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        echo "<p class='text-center'>Nenhum filme encontrado no catálogo.</p>";
                    }

                    // Fechar conexão
                    $banco->close();
                    ?>
                </div>
            </section>
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
