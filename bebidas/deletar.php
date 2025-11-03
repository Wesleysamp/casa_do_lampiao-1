<?php 
include "../conexao/conexao.php";
$conn->query("DELETE FROM bebidas WHERE id = ".$_GET['id']);
header("location:index.php");
?>