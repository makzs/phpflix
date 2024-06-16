<?php
require_once "../controller/banco.php";

// Processar o envio do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"] ?? null;
    $senha = $_POST["senha"] ?? null;

    if (!is_null($usuario) && !is_null($senha)) {
        $loginSucesso = fazerLogin($usuario, $senha);

        if ($loginSucesso) {
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Usuário ou senha incorretos.</div>";
        }
    }
}

// Função para fazer login
function fazerLogin($usuario, $senha)
{
    global $banco;

    // Consulta para verificar o usuário no banco de dados
    $query = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $banco->prepare($query);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            // Iniciar sessão e armazenar dados do usuário
            session_start();
            $_SESSION['usuario'] = $row['username'];
            return true;
        }
    }

    return false;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PHPFlix</title>
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
                        Login - PHPFlix
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group">
                                <label for="usuario">Usuário:</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
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
