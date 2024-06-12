<?php
// Conectar ao banco de dados
$banco = new mysqli("localhost", "root", "", "phpflix_db");

// Verificar conexão
if ($banco->connect_error) {
    die("Conexão falhou: " . $banco->connect_error);
}

// Verificar se o ID da imagem foi fornecido via parâmetro GET
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obter a imagem do banco de dados
    $sql = "SELECT capa FROM filmes WHERE id = $id";
    $resultado = $banco->query($sql);

    // Verificar e exibir a imagem se encontrada
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        // Configurar cabeçalhos para indicar que é uma imagem
        header("Content-Type: image/jpeg"); // ou image/png, dependendo do tipo de imagem

        // Exibir a imagem armazenada no campo "capa" do banco de dados
        echo $row['capa'];
    }
}

// Fechar conexão
$banco->close();
?>