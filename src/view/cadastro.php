<?php
require_once "../controller/banco.php";

// Processar o envio do formulário de criação de usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $e = $_POST["email"] ?? null;
    $n = $_POST["nome"] ?? null;
    $u = $_POST["usuario"] ?? null;
    $s = $_POST["senha"] ?? null;

    if (!is_null($e) && !is_null($u) && !is_null($s) && !is_null($n)) {
        $criadoComSucesso = criarUsuario($e, $u, $n, $s, "default");

        if ($criadoComSucesso) {
            header("Location: login.php");
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Falha ao criar usuário.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário - PHPFlix</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include_once "header.php"; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Criar Usuário
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="usuario">Usuário:</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Criar Usuário</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>