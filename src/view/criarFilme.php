<?php
// Verifica se o usuário está autenticado
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['nivel_acesso'] !== 'admin') {
    echo "<div class='alert alert-danger' role='alert'>Você não tem permissão para acessar esta página.</div>";
    exit();
}
require_once "../controller/banco.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? null;
    $categoria = $_POST["categoria"] ?? null;
    $nota = $_POST["nota"] ?? null;
    $duracao = $_POST["duracao"] ?? null;
    $diretor = $_POST["diretor"] ?? null;
    $link = $_POST["link"] ?? null;
    $imagem = $_FILES['imagem'];
    $imagemBinario = null;

    if (!empty($nome) && !empty($categoria) && !empty($nota) && !empty($duracao) && !empty($diretor) && !empty($link)) {
        if ($imagem['size'] > 0) {
            $imagemTmpName = $imagem['tmp_name'];
            $imagemBinario = file_get_contents($imagemTmpName);
        }

        // Insere o novo filme no banco de dados
        $criadoComSucesso = criarFilme($nome, $categoria, $nota, $duracao, $diretor, $link, $imagemBinario);

        if ($criadoComSucesso) {
            echo "<div class='alert alert-success' role='alert'>Filme criado com sucesso!</div>";
            header("Location: filmes.php");
            exit;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Falha ao criar o filme.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Por favor, preencha todos os campos obrigatórios.</div>";
    }
}

function criarFilme($nome, $categoria, $nota, $duracao, $diretor, $link, $imagemBinario)
{
    global $banco;
    $stmt = $banco->prepare("INSERT INTO filmes (nome, categoria, nota, duracao, diretor, link, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsbbs", $nome, $categoria, $nota, $duracao, $diretor, $link, $imagemBinario);
    return $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Filme - PHPFlix</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Criar Novo Filme
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="categoria">Categoria:</label>
                                <input type="text" class="form-control" id="categoria" name="categoria" required>
                            </div>
                            <div class="form-group">
                                <label for="nota">Nota:</label>
                                <input type="number" step="0.1" min="0" max="10" class="form-control" id="nota" name="nota" required>
                            </div>
                            <div class="form-group">
                                <label for="duracao">Duração (minutos):</label>
                                <input type="number" class="form-control" id="duracao" name="duracao" required>
                            </div>
                            <div class="form-group">
                                <label for="diretor">Diretor:</label>
                                <input type="text" class="form-control" id="diretor" name="diretor" required>
                            </div>
                            <div class="form-group">
                                <label for="link">Link:</label>
                                <input type="text" class="form-control" id="link" name="link" required>
                            </div>
                            <div class="form-group">
                                <label for="imagem">Imagem (JPEG):</label>
                                <input type="file" class="form-control-file" id="imagem" name="imagem" accept="image/jpeg">
                            </div>
                            <button type="submit" class="btn btn-primary">Criar Filme</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>