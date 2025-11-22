<?php
include ("../conexao/conexao.php");

$id = $_GET['id'];

// Busca os dados atuais da BEBIDA (tabela bebidas)
$sql_busca = "SELECT * FROM bebidas WHERE id=$id";
$result_busca = $conn->query($sql_busca);
$bebida = $result_busca->fetch_assoc();

// Busca categorias de bebidas para o select (tabela categorias_bebidas)
$categorias = $conn->query("SELECT * FROM categorias_bebidas");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    
    // Lógica de Upload
    $nome_final_imagem = $_POST['imagem_atual'];

    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo'];
        $pasta_destino = "../img/";
        $nome_arquivo = $arquivo['name'];
        
        // Move o arquivo e atualiza a variável
        if (move_uploaded_file($arquivo['tmp_name'], $pasta_destino . $nome_arquivo)) {
            $nome_final_imagem = $nome_arquivo;
        }
    }

    // Update no Banco (tabela bebidas)
    $sql = "UPDATE bebidas SET 
            nome='$nome', 
            descricao='$descricao', 
            preco='$preco', 
            imagem='$nome_final_imagem', 
            categoria_id='$categoria_id' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redireciona para a lista de bebidas (ajuste o link se necessário, ex: bebidas.php ou index.php)
        header("Location: index.php"); 
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Bebida | Casa do Lampião</title>
    <link rel="stylesheet" href="../css/editar.css"> 
</head>
<body>

<div class="form-container">
    <h2>✏️ Editar Bebida</h2>
    
    <form method="POST" enctype="multipart/form-data">
        
        <label for="nome">Nome da Bebida</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($bebida['nome']) ?>" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" required><?= htmlspecialchars($bebida['descricao']) ?></textarea>

        <div style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label for="preco">Preço (R$)</label>
                <input type="number" step="0.01" id="preco" name="preco" value="<?= $bebida['preco'] ?>" required>
            </div>
            <div style="flex: 1;">
                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria_id">
                    <?php while ($cat = $categorias->fetch_assoc()) { ?>
                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $bebida['categoria_id']) ? 'selected' : '' ?>>
                            <?= $cat['nome'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <label>Imagem da Bebida</label>
        <div class="file-input-wrapper">
            <input type="file" name="arquivo" accept="image/*">
            <small style="color: #888; display: block; margin-top: 5px;">Clique para alterar a foto (opcional)</small>
        </div>
        
        <input type="hidden" name="imagem_atual" value="<?= $bebida['imagem'] ?>">

        <?php if(!empty($bebida['imagem'])): ?>
            <div class="preview-container">
                <small style="display:block; margin-bottom:5px; color:#666">Imagem Atual:</small>
                <?php 
                    // Verifica se é link externo ou arquivo local
                    $imgSrc = (strpos($bebida['imagem'], 'http') === 0) ? $bebida['imagem'] : "../img/" . $bebida['imagem'];
                ?>
                <img src="<?= $imgSrc ?>" class="img-preview" alt="Imagem atual">
            </div>
        <?php endif; ?>

        <div class="btn-group">
            <a href="index.php" class="btn-form btn-cancel">
                 Cancelar
            </a>

            <button type="submit" class="btn-form btn-save">
                 Salvar Alterações
            </button>
        </div>

    </form>
</div>

</body>
</html>