<?php
require_once "../controller/banco.php";

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Deleta o filme do banco de dados
    $deletadoComSucesso = deletarFilme($delete_id);

    if ($deletadoComSucesso) {
        echo "<div class='alert alert-success' role='alert'>Filme apagado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Falha ao apagar o filme.</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>ID do filme não especificado.</div>";
    exit;
}

function deletarFilme($id)
{
    global $banco;
    $stmt = $banco->prepare("DELETE FROM filmes WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>