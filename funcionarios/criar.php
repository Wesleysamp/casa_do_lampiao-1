<?php
include ("../conexao/conexao.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $cargo = $conn->real_escape_string($_POST['cargo']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $email = $conn->real_escape_string($_POST['email']);
    $data_contratacao = $conn->real_escape_string($_POST['data_contratacao']);

    $sql = "INSERT INTO funcionarios (nome, cargo, telefone, email, data_contratacao) VALUES ('$nome', '$cargo', '$telefone', '$email', '$data_contratacao')";
    $conn->query($sql);
    header('Location: funcionarios.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Funcionário - Casa do Lampião</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Funcionário</h1>

        <form method="POST">
            Nome: <input type="text" name="nome" required><br>
            Cargo: <input type="text" name="cargo" required><br>
            Telefone: <input type="text" name="telefone" required><br>
            Email: <input type="email" name="email" required><br>
            Data: <input type="date" name="data_contratacao" required><br>
            <button type="submit">Adicionar</button>
        </form>

        <div class="back-link">
            <a href="funcionarios.php">Voltar</a>
        </div>
    </div>
</body>
</html>
