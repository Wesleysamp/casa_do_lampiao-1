<?php
include("conexao/conexao.php");

if ($_POST) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    // Verifica se email existe
    $check = $conn->query("SELECT * FROM usuarios_admin WHERE email = '$email'");
    if ($check->num_rows > 0) {
        die("E-mail já cadastrado!");
    }

    // Insere
    $sql = $conn->query("
        INSERT INTO usuarios_admin (nome, email, senha)
        VALUES ('$nome', '$email', '$senha')
    ");

    if ($sql) {
        echo "<script>window.open('index_adm.php','_self')</script>";
        exit;
    } else {
        echo "Erro ao cadastrar administrador!";
    }
}
?>
