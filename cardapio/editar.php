<?php
include ("../conexao/conexao.php");

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "UPDATE cardapio SET nome='$nome', descricao='$descricao', preco='$preco', categoria_id='$categoria_id' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}

$prato = $conn->query("SELECT * FROM cardapio WHERE id=$id")->fetch_assoc();
$categorias = $conn->query("SELECT * FROM categorias");
?>

<head>
<link rel="stylesheet" href="../css/styles.css">

</head>
<h2>Editar Prato</h2>
<form method="POST">
    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= $prato['nome'] ?>" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" required><?= $prato['descricao'] ?></textarea><br><br>

    <label>Preço:</label><br>
    <input type="number" step="0.01" name="preco" value="<?= $prato['preco'] ?>" required><br><br>

    <label>Categoria:</label><br>
    <select name="categoria_id">
        <?php while ($cat = $categorias->fetch_assoc()) { ?>
            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $prato['categoria_id']) ? 'selected' : '' ?>>
                <?= $cat['nome'] ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit">Atualizar</button>
</form>
