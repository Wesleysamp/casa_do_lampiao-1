<?php
include ("../conexao/conexao.php");
$id = (int)$_GET['id'];
$sql = "SELECT * FROM funcionarios WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $cargo = $conn->real_escape_string($_POST['cargo']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $email = $conn->real_escape_string($_POST['email']);
    $data_contratacao = $conn->real_escape_string($_POST['data_contratacao']);

    $sql = "UPDATE funcionarios SET nome='$nome', cargo='$cargo', telefone='$telefone', email='$email', data_contratacao='$data_contratacao' WHERE id=$id";
    $conn->query($sql);
    header('Location: funcionarios.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário - Casa do Lampião</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Funcionário</h1>

        <form method="POST">
            Nome: <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required><br>
            Cargo: <input type="text" name="cargo" value="<?php echo $row['cargo']; ?>" required><br>
            Telefone: <input type="text" name="telefone" value="<?php echo $row['telefone']; ?>" required><br>
            Email: <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
            Data: <input type="date" name="data_contratacao" value="<?php echo $row['data_contratacao']; ?>" required><br>
            <button type="submit">Salvar</button>
        </form>

        <div class="back-link">
            <a href="funcionarios.php">Voltar</a>
        </div>
    </div>
</body>
</html>