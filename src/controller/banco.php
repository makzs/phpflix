<?php

$banco = new mysqli("localhost", "root", "positivo", "phpflix");

// insert
function criarUsuario($email, $nickname, $nome, $senha, $tipo)
{
    global $banco;

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $q = "INSERT INTO usuarios(id, nickname, nome, senha) VALUES (NULL, '$email', '$nickname', '$nome', '$senha', '$tipo')";

    $resp = $banco->query($q);
    echo "<br> Query: " . $q;
    echo var_dump($resp);
}

// update
function editarUsuario($nomeAlterar, $senha)
{
    global $banco;

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $q = "UPDATE usuarios SET senha='$senha' WHERE nickname='$nomeAlterar'";

    $resp = $banco->query($q);
    echo "<br> Query: " . $q;
    echo var_dump($resp);
}

//delete
function deletarUsuario($nomeDeletar)
{
    global $banco;

    $q = "DELETE FROM usuarios WHERE nickname='$nomeDeletar'";

    $resp = $banco->query($q);
    echo "<br> Query: " . $q;
    echo var_dump($resp);
}