<?php 
include "../conexao/conexao.php";
$conn->query("DELETE FROM cardapio WHERE id = ".$_GET['id']);
header("location:index.php");
?>