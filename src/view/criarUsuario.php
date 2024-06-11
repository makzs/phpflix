<?php
require_once "banco.php";

$e = $_POST["email"] ?? null;
$n = $_POST["nome"] ?? null;
$u = $_POST["usuario"] ?? null;
$s = $_POST["senha"] ?? null;
$t = $_POST["tipo"] ?? null;



if (is_null($e) || is_null($u) || is_null($s) || is_null($n)) {
    require "formularios/formularioCriar.php";
} else {
    criarUsuario($e, $u, $n, $s, $t);
    echo "Usuario criado com sucesso";
}