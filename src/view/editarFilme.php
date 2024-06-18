<?php
// Verifica se o usuário está autenticado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['nivel_acesso'] !== 'admin') {
    echo "<div class='alert alert-danger' role='alert'>Você não tem permissão para acessar esta página.</div>";
    exit();
}

require_once "../controller/banco.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $banco->prepare("SELECT * FROM filmes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<div class='alert alert-danger' role='alert'>Filme não encontrado.</div>";
        exit;
    }

    $filme = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"] ?? null;
        $categoria = $_POST["categoria"] ?? null;
        $nota = $_POST["nota"] ?? null;
        $duracao = $_POST["duracao"] ?? null;
        $link = $_POST["link"] ?? null;
        $imagem = $_FILES['imagem'];
        $imagemBinario = null;

        if (!empty($nome) && !empty($categoria) && !empty($nota) && !empty($duracao) && !empty($link)) {
            if ($imagem['size'] > 0) {
                $imagemTmpName = $imagem['tmp_name'];
                $imagemBinario = file_get_contents($imagemTmpName);
            }

            $editadoComSucesso = editarFilme($id, $nome, $categoria, $nota, $duracao, $link, $imagemBinario);

            if ($editadoComSucesso) {
                echo "<div class='alert alert-success' role='alert'>Filme editado com sucesso!</div>";
                echo "<script>window.location.href = 'movie_details.php?id={$id}';</script>";
                exit;
            } else {
                echo "<div class='alert alert-danger' role='alert'>Falha ao editar o filme.</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Por favor, preencha todos os campos.</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>ID do filme não especificado.</div>";
    exit;
}

function editarFilme($id, $nome, $categoria, $nota, $duracao, $link, $imagemBinario)
{
    global $banco;

    // Process the image upload
    if ($imagemBinario) {
        $imagemTmpName = $_FILES['imagem']['tmp_name'];
        $imagemBinario = file_get_contents($imagemTmpName);
    }

    // Prepare the update statement
    $stmt = $banco->prepare("UPDATE filmes SET nome = ?, categoria = ?, nota = ?, duracao = ?, link = ?, imagem = ? WHERE id = ?");
    $stmt->bind_param("ssdsbsi", $nome, $categoria, $nota, $duracao, $link, $imagemBinario, $id);

    // Execute the update
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Filme - PHPFlix</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Editar Filme
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>"
                            method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    value="<?php echo htmlspecialchars($filme['nome']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="categoria">Categoria:</label>
                                <input type="text" class="form-control" id="categoria" name="categoria"
                                    value="<?php echo htmlspecialchars($filme['categoria']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nota">Nota:</label>
                                <input type="number" step="0.1" min="0" max="10" class="form-control" id="nota"
                                    name="nota" value="<?php echo htmlspecialchars($filme['nota']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="duracao">Duração (minutos):</label>
                                <input type="time" class="form-control" id="duracao" name="duracao"
                                    value="<?php echo htmlspecialchars($filme['duracao']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="link">Link:</label>
                                <input type="text" class="form-control" id="link" name="link"
                                    value="<?php echo htmlspecialchars($filme['link']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="imagem">Imagem (JPEG):</label>
                                <input type="file" class="form-control-file" id="imagem" name="imagem"
                                    accept="image/jpeg">
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>