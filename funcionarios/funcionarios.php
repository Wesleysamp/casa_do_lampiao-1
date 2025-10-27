<?php
// Incluir a conexão
include ("../conexao/conexao.php");
// Buscar funcionários
$sql = "SELECT * FROM funcionarios";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Funcionários - Casa do Lampião</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Funcionários - Casa do Lampião</h1>

        <a href="criar.php" class="add-button">Adicionar Funcionário</a>

        <table>
            <tr><th>ID</th><th>Nome</th><th>Cargo</th><th>Telefone</th><th>Email</th><th>Data</th><th>Ações</th></tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['cargo']; ?></td>
                    <td><?php echo $row['telefone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['data_contratacao']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                        <a href="deletar.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Remover?')">Remover</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php $conn->close(); ?>
</body>
</html>