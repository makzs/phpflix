<?php
require_once "banco.php";

$n = $_POST["nome"] ?? null;
$u = $_POST["usuario"] ?? null;
$s = $_POST["senha"] ?? null;



if (is_null($u) || is_null($s) || is_null($n)) {
    require "formularios/formularioCriar.php";
} else {
    criarUsuario($u, $n, $s);
    echo "Usuario criado com sucesso";
}