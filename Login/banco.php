<?php

$banco = new mysqli("localhost:3307", "root", "", "bancoteste");

// insert
function criarUsuario($usuario, $nome, $senha)
{
    global $banco;

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $q = "INSERT INTO usuarios(codigo, usuario, nome, senha) VALUES (NULL, '$usuario', '$nome', '$senha')";

    $resp = $banco->query($q);
    echo "<br> Query: " . $q;
    echo var_dump($resp);
}

// update
function editarUsuario($nomeAlterar, $senha)
{
    global $banco;

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $q = "UPDATE usuarios SET senha='$senha' WHERE usuario='$nomeAlterar'";

    $resp = $banco->query($q);
    echo "<br> Query: " . $q;
    echo var_dump($resp);
}

//delete
function deletarUsuario($nomeDeletar)
{
    global $banco;

    $q = "DELETE FROM usuarios WHERE usuario='$nomeDeletar'";

    $resp = $banco->query($q);
    echo "<br> Query: " . $q;
    echo var_dump($resp);
}