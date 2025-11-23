<?php
include ("../conexao/conexao.php");

// Busca categorias de bebidas para o select
$categorias_bebidas = mysqli_query($conn, "SELECT * FROM categorias_bebidas");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];

    // --- LÓGICA DE UPLOAD DE IMAGEM ---
    $nome_final_imagem = ""; // Começa vazio caso não suba imagem

    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo'];
        $pasta_destino = "../img/"; // Pasta onde a foto será salva
        $nome_arquivo = $arquivo['name'];

        // Tenta mover o arquivo para a pasta
        if (move_uploaded_file($arquivo['tmp_name'], $pasta_destino . $nome_arquivo)) {
            $nome_final_imagem = $nome_arquivo;
        }
    }

    // Insere na tabela BEBIDAS (incluindo a imagem)
    $sql = "INSERT INTO bebidas (nome, descricao, preco, imagem, categoria_id)
            VALUES ('$nome', '$descricao', '$preco', '$nome_final_imagem', '$categoria_id')";

    if (mysqli_query($conn, $sql)) {
        // Redireciona para a lista de bebidas (ajuste se seu arquivo for index.php)
        header("Location: bebidas.php"); 
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
    <title>Nova Bebida | Casa do Lampião</title>

    <link rel="stylesheet" href="../css/editar.css">
</head>

<body>

<div class="form-container">
    <h2>🍹
 Adicionar Nova Bebida</h2>

    <form method="POST" enctype="multipart/form-data">

        <label for="nome">Nome da Bebida</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Suco de Graviola" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" placeholder="Descreva a bebida (ex: Copo de 500ml, com gelo...)" required></textarea>

        <div style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label for="preco">Preço (R$)</label>
                <input type="number" step="0.01" id="preco" name="preco" placeholder="0.00" required>
            </div>
            <div style="flex: 1;">
                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria_id" required>
                    <option value="" disabled selected>Selecione...</option>
                    <?php while ($cb = mysqli_fetch_assoc($categorias_bebidas)) { ?>
                        <option value="<?= $cb['id'] ?>"><?= $cb['nome'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <label>Imagem da Bebida</label>
        <div class="file-input-wrapper">
            <input type="file" name="arquivo" accept="image/*">
            <small style="color: #888; display: block; margin-top: 5px;">Clique para escolher uma foto (JPG, PNG)</small>
        </div>

        <div class="btn-group">
            <a href="bebidas.php" class="btn-form btn-cancel">
                 Cancelar
            </a>

            <button type="submit" class="btn-form btn-save">
                 Cadastrar Bebida
            </button>
        </div>

    </form>
</div>

</body>
</html>