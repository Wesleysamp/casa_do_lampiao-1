<?php
include "../conexao/conexao.php";

// Query corrigida
$sql = "SELECT b.id, b.nome, b.descricao, b.preco, cb.nome AS categoria 
        FROM bebidas b
        JOIN categorias_bebidas cb ON b.categoria_id = cb.id";

$result = $conn->query($sql);

// Verifica se houve erro na query
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa do Lampião - Bebidas</title>
    <link rel="stylesheet" href="../css/styles.css">

</head>

<body>
    <h2>Bebidas</h2>
    <a href="criar.php">Adicionar Nova Bebida</a>

    <table border="1" cellpadding="10">
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>

        <?php 
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()): 
        ?>
        <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['descricao']) ?></td>
            <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['categoria']) ?></td>
            <td>
                <a href="editar.php?id=<?= $row['id'] ?>">Editar</a> | 
                <a href="deletar.php?id=<?= $row['id'] ?>" onclick="return confirm('Deseja excluir esta bebida?')">Excluir</a>
            </td>
        </tr>
        <?php 
            endwhile;
        } else {
            echo "<tr><td colspan='5' style='text-align: center;'>Nenhuma bebida encontrada.</td></tr>";
        }
        ?>
    </table>
</body>
</html>