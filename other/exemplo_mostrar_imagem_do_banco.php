<?php
$conexao = new mysqli("localhost", "root", "positivo", "phpflix");

// ID da imagem que você deseja recuperar
$idImagem = 1;

// Consulta para recuperar os dados binários da imagem
$sql = "SELECT imagem FROM filmes WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $idImagem);
$stmt->execute();
$stmt->bind_result($imagemBinaria);
$stmt->fetch();
$stmt->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exibição de Imagem</title>
</head>
<body>
    <!-- Exibe a imagem -->
    <img src="data:image/jpeg;base64,<?php echo base64_encode($imagemBinaria); ?>" alt="Minha Imagem">
</body>
</html>