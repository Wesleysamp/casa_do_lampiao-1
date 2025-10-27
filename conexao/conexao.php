<?php
$hostname = "localhost";
$usuario = "root";
$senha = "";
$banco = "casa_do_lampiao";

$conn = new mysqli($hostname, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>