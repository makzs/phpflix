<?php

$banco = new mysqli("localhost", "root", "", "phpflix_db");

// Verificar conexão
if ($banco->connect_error) {
    die("Conexão falhou: " . $banco->connect_error);
}

// Função para criar um novo usuário
function criarUsuario($email, $nickname, $nome, $senha, $tipo) {
    global $banco;

    // Preparar a senha com hash
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar a query usando prepared statement
    $stmt = $banco->prepare("INSERT INTO usuarios (id, email, username, nome, senha, tipo) VALUES (NULL, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $nickname, $nome, $senhaHash, $tipo);

    if ($stmt->execute()) {
        return true; 
    } else {
        return false;
    }
}

// Função para editar a senha de um usuário
function editarUsuario($nickname, $novaSenha) {
    global $banco;

    // Preparar a nova senha com hash
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    // Preparar a query usando prepared statement
    $stmt = $banco->prepare("UPDATE usuarios SET senha = ? WHERE username = ?");
    $stmt->bind_param("ss", $senhaHash, $nickname);

    if ($stmt->execute()) {
        return true; 
    } else {
        return false;
    }
}

// Função para deletar um usuário
function deletarUsuario($nickname) {
    global $banco;

    // Preparar a query usando prepared statement
    $stmt = $banco->prepare("DELETE FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $nickname);

    if ($stmt->execute()) {
        return true; 
    } else {
        return false;
    }
}
?>
