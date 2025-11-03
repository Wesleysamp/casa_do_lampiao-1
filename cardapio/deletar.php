<?php 
include "../conexao/conexao.php";
$conn->query("DELETE FROM pratos WHERE id = ".$_GET['id']);
header("location:index.php");
?>