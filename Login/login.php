<?php
require_once "banco.php";

$u = $_POST["usuario"] ?? null;
$s = $_POST["senha"] ?? null;

if (is_null($u) || is_null($s)) {
    require "formularios/formularioLogin.php";
} else {

    $q = "SELECT usuario, nome, senha FROM usuarios
        WHERE usuario='$u'";

    $busca = $banco->query($q);
    print_r($busca);

    if ($busca->num_rows > 0) {

        $usu = $busca->fetch_object();

        // echo "<br>" . $usu->senha;

        if (password_verify($s, $usu->senha)) {
            echo "Login :)";
        } else {
            require "formularioLogin.php"; // para testes
            echo "Senha Inválida :/";
        }
    } else {
        require "formularioLogin.php"; // para testes
    }
}