<?php
include ("../conexao/conexao.php");
$id = (int)$_GET['id'];
$sql = "DELETE FROM funcionarios WHERE id=$id";
$conn->query($sql);
header('Location: funcionarios.php');
?>

