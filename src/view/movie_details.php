<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPflix - Movie Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .movie-details {
            display: flex;
            flex-wrap: wrap;
        }

        .movie-image {
            width: 50%;
            padding: 10px;
        }

        .movie-image img {
            width: 100%;
            /* Set image width to 100% of its container */
            height: auto;
            /* Maintain aspect ratio */
        }

        .movie-info {
            width: 50%;
            padding: 15px;
        }

        .movie-title {
            margin-top: 0;
        }

        .movie-info p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include "header.php";

    require_once "../controller/banco.php";

    if ($banco->connect_error) {
        die("Connection failed: " + $banco->connect_error);
    }

    $movieID = $_GET['id'];

    $sql = "SELECT * FROM filmes WHERE id = $movieID";
    $result = $banco->query($sql);

    if ($result->num_rows == 0) {
        echo "Movie not found.";
        exit();
    }

    $movie = $result->fetch_assoc();
    $base64_image = base64_encode($movie['imagem']);

    $banco->close();
    ?>

    <div class="container mt-3 movie-details">
        <div class="movie-image">
            <img src="data:image/jpeg;base64,<?php echo $base64_image; ?>" class="img-fluid"
                alt="<?php echo $movie['nome']; ?>">
        </div>
        <div class="movie-info">
            <h1 class="movie-title"><?php echo $movie['nome']; ?></h1>
            <div>
                <?php
                if (isset($movie['link']) && !empty($movie['link'])) {
                    // Extract video ID from URL (assuming YouTube URL format)
                    $videoID = parse_youtube_video_id($movie['link']);

                    if ($videoID) {
                        // Generate iframe embed URL
                        $iframeURL = "https://www.youtube.com/embed/$videoID?controls=0&autoplay=0&showinfo=0";

                        // Generate iframe HTML with desired dimensions
                        echo "<iframe src='$iframeURL' width='720' height='420' frameborder='0,5' allowfullscreen></iframe>";
                    }
                }
                function parse_youtube_video_id($url)
                {
                    $pattern = '/^.*(?:(?:youtu\.be\/|v\/|watch\?v=|\.com\/embed\/))([\w-]{11})(?:[\?&%]*).*$/';
                    preg_match($pattern, $url, $matches);
                    return $matches[1] ?? null;
                }
                ?>
            </div>
            <p>Categoria: <?php echo $movie['categoria']; ?></p>
            <p>Duração: <?php echo $movie['duracao']; ?></p>
            <p>Nota: <?php echo $movie['nota']; ?></p>
            <?php if (isset($_SESSION['usuario']) && isset($_SESSION['nivel_acesso']) && $_SESSION['nivel_acesso'] === 'admin'): ?>
                <div class='text-right'>
                    <a href="editarFilme.php?id=<?php echo $movieID; ?>" class="btn btn-warning mr-2">Editar Filme</a>
                    <a href="deletarFilme.php?id=<?php echo $movieID; ?>" class="btn btn-danger">Deletar Filme</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 PHPflix. Todos os direitos reservados.</p>
    </footer>
</body>

</html>