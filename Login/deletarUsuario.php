<?php
require_once "banco.php";

$n = $_POST["nickname"] ?? null;

if (is_null($n)) {
    require "formularios/formularioDeletar.php";
} else {
    deletarUsuario($n);
    echo "Usuario Deletado com sucesso";
}