<?php
include ("../conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "INSERT INTO pratos (nome, descricao, preco, categoria_id)
            VALUES ('$nome', '$descricao', '$preco', '$categoria_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao salvar: " . mysqli_error($conn);
    }
}

$categorias = mysqli_query($conn, "SELECT * FROM categorias");
?>

<head>
<link rel="stylesheet" href="../css/styles.css">

</head>
<h2>Adicionar Novo Prato</h2>
<form method="POST">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Descrição:</label><br>
    <textarea name="descricao" required></textarea><br><br>

    <label>Preço:</label><br>
    <input type="number" step="0.01" name="preco" required><br><br>

    <label>Categoria:</label><br>
    <select name="categoria_id" required>
        <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['nome'] ?></option>
        <?php } ?>
    </select><br><br>

    <button type="submit">Salvar</button>
</form>
