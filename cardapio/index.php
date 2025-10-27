<?php
include "../conexao/conexao.php";

$sql = "SELECT c.id, c.nome, c.descricao, c.preco, cat.nome AS categoria 
        FROM cardapio c
        JOIN categorias cat ON c.categoria_id = cat.id";

$result = $conn->query($sql);


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa do Lampião</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<h2>Cardápio</h2>
<a href="criar.php">Adicionar Novo Prato</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Categoria</th>
        <th>Ações</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['nome']) ?></td>
        <td><?= htmlspecialchars($row['descricao']) ?></td>
        <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
        <td><?= htmlspecialchars($row['categoria']) ?></td>
        <td>
            <a href="editar.php?id=<?= $row['id'] ?>">Editar</a> | 
            <a href="deletar.php?id=<?= $row['id'] ?>" onclick="return confirm('Deseja excluir este prato?')">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
