<?php
include ("../conexao/conexao.php");

// Busca categorias para preencher o select
$categorias = mysqli_query($conn, "SELECT * FROM categorias");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];

    
    $nome_final_imagem = ""; // Começa vazio caso não suba imagem

    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo'];
        $pasta_destino = "../img/"; 
        $nome_arquivo = $arquivo['name'];

        // Tenta mover o arquivo para a pasta
        if (move_uploaded_file($arquivo['tmp_name'], $pasta_destino . $nome_arquivo)) {
            $nome_final_imagem = $nome_arquivo;
        }
    }

    // Insere no banco 
    $sql = "INSERT INTO pratos (nome, descricao, preco, imagem, categoria_id)
            VALUES ('$nome', '$descricao', '$preco', '$nome_final_imagem', '$categoria_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Erro ao salvar: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Prato | Casa do Lampião</title>
    <link rel="stylesheet" href="../css/editar.css">
</head>

<body>

<div class="form-container">
    <h2>➕
 Adicionar Novo Prato</h2>

    <form method="POST" enctype="multipart/form-data">

        <label for="nome">Nome do Prato</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Baião de Dois" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" placeholder="Descreva os ingredientes e detalhes do prato..." required></textarea>

        <div style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label for="preco">Preço (R$)</label>
                <input type="number" step="0.01" id="preco" name="preco" placeholder="0.00" required>
            </div>
            <div style="flex: 1;">
                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria_id" required>
                    <option value="" disabled selected>Selecione...</option>
                    <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['nome'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <label>Imagem do Prato</label>
        <div class="file-input-wrapper">
            <input type="file" name="arquivo" accept="image/*">
            <small style="color: #888; display: block; margin-top: 5px;">Clique para escolher uma foto (JPG, PNG)</small>
        </div>

        <div class="btn-group">
            <a href="index.php" class="btn-form btn-cancel">
                 Cancelar
            </a>

            <button type="submit" class="btn-form btn-save">
                 Cadastrar Prato
            </button>
        </div>

    </form>
</div>

</body>
</html>