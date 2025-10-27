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
        header("Location: bebidas.php");
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}

$bebidas = $conn->query("SELECT * FROM bebidas WHERE id=$id")->fetch_assoc();
$categorias_bebidas = $conn->query("SELECT * FROM categorias_bebidas");
?>

<head>
<link rel="stylesheet" href="../css/styles.css">

</head>
<h2>Editar Bebidas</h2>
<form method="POST">
    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= $bebidas['nome'] ?>" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" required><?= $bebidas['descricao'] ?></textarea><br><br>

    <label>Preço:</label><br>
    <input type="number" step="0.01" name="preco" value="<?= $bebidas['preco'] ?>" required><br><br>

    <label>Categoria:</label><br>
    <select name="categoria_id">
        <?php while ($cb = $categorias_bebidas->fetch_assoc()) { ?>
            <option value="<?= $cb['id'] ?>" <?= ($cb['id'] == $bebidas['categoria_id']) ? 'selected' : '' ?>>
                <?= $cb['nome'] ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit">Atualizar</button>
</form>
